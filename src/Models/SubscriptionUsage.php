<?php

declare(strict_types=1);

namespace Soap\LaravelSubscriptions\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $subscription_id
 * @property int $feature_id
 * @property int $used
 * @property \Carbon\Carbon $valid_until
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Soap\LaravelSubscriptions\Models\PlanFeature $feature
 * @property-read \Soap\LaravelSubscriptions\Models\Subscription $subscription
 */
class SubscriptionUsage extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'subscription_id',
        'feature_id',
        'used',
        'valid_until',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'subscription_id' => 'integer',
        'feature_id' => 'integer',
        'used' => 'integer',
        'valid_until' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getTable()
    {
        return config('subscriptions.tables.subscription_usages');
    }

    /**
     * Subscription usage always belongs to a plan feature.
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(config('subscriptions.models.plan_feature'), 'feature_id', 'id', 'feature');
    }

    /**
     * Subscription usage always belongs to a plan subscription.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(config('subscriptions.models.subscription'), 'subscription_id', 'id', 'subscription');
    }

    /**
     * Scope subscription usage by feature name.
     */
    public function scopeByFeatureName(Builder $builder, string $featureName): Builder
    {
        $feature = PlanFeature::where('name', $featureName)->first();

        return $builder->where('feature_id', $feature->getKey() ?? null);
    }

    /**
     * Check whether usage has been expired or not.
     */
    public function expired(): bool
    {
        if (is_null($this->valid_until)) {
            return false;
        }

        return Carbon::now()->gte($this->valid_until);
    }
}
