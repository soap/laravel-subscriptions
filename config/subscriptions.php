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
        'subscription_usages' => 'subscription_usages',

    ],

    // Subscriptions Models
    'models' => [
        'plan' => \Soap\LaravelSubscriptions\Models\Plan::class,
        'feature' => \Soap\LaravelSubscriptions\Models\Feature::class,
        'plan_feature' => \Soap\LaravelSubscriptions\Models\PlanFeature::class,
        'subscription' => \Soap\LaravelSubscriptions\Models\Subscription::class,
        'subscription_usage' => \Soap\LaravelSubscriptions\Models\SubscriptionUsage::class,
    ],

];
