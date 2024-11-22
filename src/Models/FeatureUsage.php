<?php

declare(strict_types=1);

namespace Soap\LaravelSubscriptions\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $subscriber_type
 * @property int $subscriber_id
 * @property int $feature_id
 * @property int $used
 * @property \Carbon\Carbon $valid_until
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Soap\LaravelSubscriptions\Models\PlanFeature $feature
 * @property-read \Soap\LaravelSubscriptions\Models\Subscription $subscription
 */
class FeatureUsage extends Model
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
        'subscriber_type' => 'string',
        'subscriber_id' => 'integer',
        'feature_id' => 'integer',
        'used' => 'decimal:2',
        'valid_until' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return config('subscriptions.tables.feature_usages');
    }

    public function subscriber(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Subscription usage always belongs to a plan feature.
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(config('subscriptions.models.plan_feature'), 'feature_id', 'id', 'feature');
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

    public function notExpired(): bool
    {
        return ! $this->expired();
    }
}
