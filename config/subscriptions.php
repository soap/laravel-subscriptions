<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Subscriptions Database Tables
    'tables' => [
        'plans' => 'plans',
        'plan_features' => 'plan_features',
        'plan_subscriptions' => 'plan_subscriptions',
        'plan_subscription_usage' => 'plan_subscription_usage',

    ],

    // Subscriptions Models
    'models' => [
        'plan' => \Soap\LaravelSubscriptions\Models\Plan::class,
        'plan_feature' => \Soap\LaravelSubscriptions\Models\PlanFeature::class,
        'plan_subscription' => \Soap\LaravelSubscriptions\Models\PlanSubscription::class,
        'plan_subscription_usage' => \Soap\LaravelSubscriptions\Models\PlanSubscriptionUsage::class,

    ],

];
