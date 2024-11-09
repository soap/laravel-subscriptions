<?php

namespace Soap\LaravelSubscriptions;

use Soap\LaravelSubscriptions\Commands\LaravelSubscriptionsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelSubscriptionsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-subscriptions')
            ->hasConfigFile()
            ->hasMigrations([
                'create_plans_table',
                'create_plan_subscriptions_table',
                'create_plan_features_table',
                'create_plan_subscription_usages_table',
            ])
            ->hasCommand(LaravelSubscriptionsCommand::class);
    }
}
