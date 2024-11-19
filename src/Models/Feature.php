<?php

namespace Soap\LaravelSubscriptions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Soap\LaravelSubscriptions\Traits\HasSlug;
use Soap\LaravelSubscriptions\Traits\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\SlugOptions;

class Feature extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use SortableTrait;

    protected $fillable = [
        'name',
        'description',
        'consumable',
        'quota',
        'post_paid',
        'renewable_period',
        'renewable_interval',
    ];
    
    protected $casts = [
        'consumable' => 'boolean',
        'quota' => 'boolean',
        'post_paid' => 'boolean',
        'renewable_period' => 'integer',
        'renewable_interval' => 'string',
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

    public $sortable = [
        'order_column_name' => 'sort_order',
    ];

    public function getTable()
    {
        return config('subscriptions.tables.features');
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
}