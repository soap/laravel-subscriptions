<?php

declare(strict_types=1);

namespace Soap\LaravelSubscriptions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property int $plan_id
 */
class PlanFeature extends Pivot implements Sortable
{
    use HasFactory;
    use SortableTrait;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'plan_id',
        'feature_id',
        'value',
        'unit',
        'sort_order',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'plan_id' => 'integer',
        'value' => 'deciaml',
        'sort_order' => 'integer',
    ];

    /**
     * The sortable settings.
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'sort_order',
    ];

    public function getTable(): string
    {
        return config('subscriptions.tables.plan_features');
    }

    /**
     * The plan feature may have many subscription usage.
     */
    public function usages(): HasMany
    {
        return $this->hasMany(config('subscriptions.models.feature_usage'), 'feature_id', 'id');
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(config('subscriptions.models.feature'));
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(config('subscriptions.models.plan'));
    }
}
