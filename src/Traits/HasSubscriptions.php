<?php

namespace Soap\LaravelSubscriptions\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Soap\LaravelSubscriptions\Models\Plan;
use Soap\LaravelSubscriptions\Models\Subscription;
use Soap\LaravelSubscriptions\Period;

trait HasSubscriptions
{
    protected ?Collection $loadedFeatures = null;

    protected ?Collection $loadedSubscriptionFeatures = null;

    protected static function bootHasSubscriptions(): void
    {
        static::deleted(function ($plan): void {
            $plan->subscriptions()->delete();
        });
    }

    public function featureUsages()
    {
        $this->morphMany(config('subscriptions.models.feature_usage'), 'subscriber');
    }

    /**
     * The subscriber may have many plan subscriptions.
     */
    public function subscriptions(): MorphMany
    {
        return $this->morphMany(
            related: config('subscriptions.models.subscription'),
            name: 'subscriber',
            type: 'subscriber_type',
            id: 'subscriber_id'
        );
    }

    public function subscription()
    {
        return $this->morphOne(config('soulbscription.models.subscription'), 'subscriber')->ofMany('starts_at', 'MAX');
    }

    public function activeSubscriptions(): Collection
    {
        return $this->subscriptions->reject->inactive();
    }

    public function subscriptionBySlug(string $subscriptionSlug): ?Subscription
    {
        return $this->subscriptions()->where('slug', 'like', '%'.$subscriptionSlug.'%')->first();
    }

    public function subscribedPlans(): Collection
    {
        $planIds = $this->subscriptions->reject
            ->inactive()
            ->pluck('plan_id')
            ->unique();

        return tap(new (config('subscriptions.models.plan')))->whereIn('id', $planIds)->get();
    }

    public function subscribedTo(int $planId): bool
    {
        $subscription = $this->subscriptions()
            ->where('plan_id', $planId)
            ->first();

        return $subscription && $subscription->active();
    }

    public function newSubscription(string $subscription, Plan $plan, ?Carbon $startDate = null): Subscription
    {
        $trial = new Period(
            interval: $plan->trial_interval,
            count: $plan->trial_period,
            start: $startDate ?? Carbon::now()
        );

        $period = new Period(
            interval: $plan->invoice_interval,
            count: $plan->invoice_period,
            start: $trial->getEndDate()
        );

        $grace = ($plan->grace_period > 0) ? new Period(
            interval: $plan->grace_interval,
            count: $plan->grace_period,
            start: $period->getEndDate()
        ) : null;

        return $this->subscriptions()->create([
            'name' => $subscription,
            'plan_id' => $plan->getKey(),
            'trial_period_ends_at' => $trial->getEndDate(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate(),
            'grace_period_ends_at' => $grace ? grace->getEndDate() : null,
        ]);
    }

    public function consume($featureSlug, ?float $consumption = null): bool
    {
        if (! $this->canConsume($featureSlug, $consumption)) {
            return false;
        }

        $feature = $this->getFeatureBySlug($featureSlug);

        $featureUsage = $feature->is_quota
            ? $this->consumeQuotaFeature($feature, $consumption)
            : $this->consumeNotQuotaFeature($feature, $consumption);

        event(new FeatureConsumed($this, $feature, $featureUsage));

        return true;
    }

    public function setConsumedQuota($featureSlug, float $consumption): bool
    {
        if (! $this->canConsume($featureSlug, $consumption)) {
            return false;
        }

        $feature = $this->getFeatureBySlug($featureSlug);

        $featureUsage = $this->consumeQuotaFeature($feature, $consumption);

        event(new FeatureConsumed($this, $feature, $featureUsage));

        return true;
    }

    public function canConsume($featureSlug, ?float $consumption = null): bool
    {
        if (empty($feature = $this->getFeatureBySlug($featureSlug))) {
            return false;
        }

        if (! $feature->is_consumable) {
            return true;
        }

        if ($feature->is_postpaid) {
            return true;
        }

        $remainingCredits = $this->getRemainingCredits($featureSlug);

        return $remainingCredits >= $consumption;
    }

    public function cantConsume($featureSlug, ?float $consumption = null): bool
    {
        return ! $this->canConsume($featureSlug, $consumption);
    }

    public function balance($featureSlug): int
    {
        if (empty($this->getFeatureBySlug($featureSlug))) {
            return 0;
        }

        $currentConsumption = $this->getCurrentConsumption($featureSlug);
        $totalCredits = $this->getTotalCredits($featureSlug);

        return $totalCredits - $currentConsumption;
    }

    public function getCurrentConsumption($featurSlug): float
    {
        if (empty($feature = $this->getFeatureBySlug($featureSlug))) {
            return 0;
        }

        return $this->featureUsages()
            ->whereBelongsTo($feature)
            ->sum('used');
    }

    public function missingFeature($featureSlug): bool
    {
        return empty($this->getFeatureBySlug($featureSlug));
    }

    public function hasFeature($featureName): bool
    {
        return ! $this->missingFeature($featureName);
    }

    public function getFeatureBySlug(string $featureName): ?Feature
    {
        $feature = $this->features->firstWhere('slug', $featureSlug);

        return $feature;
    }

    public function getFeaturesAttribute(): Collection
    {
        if (! is_null($this->loadedFeatures)) {
            return $this->loadedFeatures;
        }

        $this->loadedFeatures = $this->loadSubscriptionFeatures();

        return $ths->loadedFeatures;

    }

    protected function loadSubscriptionFeatures(): Collection
    {
        if (! is_null($this->loadedSubscriptionFeatures)) {
            return $this->loadedSubscriptionFeatures;
        }

        //$this->loadMissing('subscriptions.plan.features');

        return $this->loadedSubscriptionFeatures = $this->subscription->plan->features ?? Collection::empty();
    }
}
