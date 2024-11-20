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
    protected static function bootHasSubscriptions(): void
    {
        static::deleted(function ($plan): void {
            $plan->subscriptions()->delete();
        });
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

    public function activeSubscriptions(): Collection
    {
        return $this->subscriptions->reject->inactive();
    }

    public function subscription(string $subscriptionSlug): ?Subscription
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

        return $this->subscriptions()->create([
            'name' => $subscription,
            'plan_id' => $plan->getKey(),
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate(),
        ]);
    }
}
