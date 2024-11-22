<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Subscriptions Database Tables
    'tables' => [
        'plans' => 'plans',
        'features' => 'features',
        'plan_features' => 'plan_features',
        'subscriptions' => 'subscriptions',
        'feature_usages' => 'feature_usages',

    ],

    // Subscriptions Models
    'models' => [
        'plan' => \Soap\LaravelSubscriptions\Models\Plan::class,
        'feature' => \Soap\LaravelSubscriptions\Models\Feature::class,
        'plan_feature' => \Soap\LaravelSubscriptions\Models\PlanFeature::class,
        'subscription' => \Soap\LaravelSubscriptions\Models\Subscription::class,
        'feature_usage' => \Soap\LaravelSubscriptions\Models\FeatureUsage::class,
    ],

];
