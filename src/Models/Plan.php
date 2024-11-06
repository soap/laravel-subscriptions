<?php

declare(strict_types=1);

namespace Soap\LaravelSubscriptions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property float $price
 * @property float $signup_fee
 * @property string $currency
 * @property int $trial_period
 * @property string $trial_interval
 * @property int $invoice_period
 * @property string $invoice_interval
 * @property int $grace_period
 * @property string $grace_interval
 * @property int $prorate_day
 * @property int $prorate_period
 * @property int $prorate_extend_due
 * @property int $active_subscribers_limit
 * @property int $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Soap\LaravelSubscriptions\Models\PlanFeature[] $features
 * @property-read int|null $features_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Soap\LaravelSubscriptions\Models\PlanSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 */
class Plan extends Model implements Sortable
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use SortableTrait;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
        'price',
        'signup_fee',
        'currency',
        'trial_period',
        'trial_interval',
        'invoice_period',
        'invoice_interval',
        'grace_period',
        'grace_interval',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit',
        'sort_order',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'slug' => 'string',
        'is_active' => 'boolean',
        'price' => 'float',
        'signup_fee' => 'float',
        'currency' => 'string',
        'trial_period' => 'integer',
        'trial_interval' => 'string',
        'invoice_period' => 'integer',
        'invoice_interval' => 'string',
        'grace_period' => 'integer',
        'grace_interval' => 'string',
        'prorate_day' => 'integer',
        'prorate_period' => 'integer',
        'prorate_extend_due' => 'integer',
        'active_subscribers_limit' => 'integer',
        'sort_order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'name',
        'description',
    ];

    /**
     * The sortable settings.
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'sort_order',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /*
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('subscriptions.tables.plans'));
        $this->setRules([
            'slug' => 'required|alpha_dash|max:150|unique:'.config('subscriptions.tables.plans').',slug',
            'name' => 'required|string|strip_tags|max:150',
            'description' => 'nullable|string|max:10000',
            'is_active' => 'sometimes|boolean',
            'price' => 'required|numeric',
            'signup_fee' => 'required|numeric',
            'currency' => 'required|alpha|size:3',
            'trial_period' => 'sometimes|integer|max:10000',
            'trial_interval' => 'sometimes|in:hour,day,week,month',
            'invoice_period' => 'sometimes|integer|max:10000',
            'invoice_interval' => 'sometimes|in:hour,day,week,month',
            'grace_period' => 'sometimes|integer|max:10000',
            'grace_interval' => 'sometimes|in:hour,day,week,month',
            'sort_order' => 'nullable|integer|max:10000',
            'prorate_day' => 'nullable|integer|max:150',
            'prorate_period' => 'nullable|integer|max:150',
            'prorate_extend_due' => 'nullable|integer|max:150',
            'active_subscribers_limit' => 'nullable|integer|max:10000',
        ]);
    }
    */

    public function getTable()
    {
        return config('subscriptions.tables.plans');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->doNotGenerateSlugsOnUpdate()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * The plan may have many features.
     */
    public function features(): HasMany
    {
        return $this->hasMany(config('subscriptions.models.plan_feature'), 'plan_id', 'id');
    }

    /**
     * The plan may have many subscriptions.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(config('subscriptions.models.plan_subscription'), 'plan_id', 'id');
    }

    /**
     * Check if plan is free.
     */
    public function isFree(): bool
    {
        return (float) $this->price <= 0.00;
    }

    /**
     * Check if plan has trial.
     */
    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
    }

    /**
     * Check if plan has grace.
     */
    public function hasGrace(): bool
    {
        return $this->grace_period && $this->grace_interval;
    }

    public function getFeatureBySlug(string $featureSlug): ?PlanFeature
    {
        /** @var PlanFeature */
        return $this->features()->where('slug', $featureSlug)->first();
    }

    /**
     * Activate the plan.
     *
     * @return $this
     */
    public function activate()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the plan.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);

        return $this;
    }
}
