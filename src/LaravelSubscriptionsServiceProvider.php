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
                '0001_create_plans_table',
                '0002_create_plan_features_table',
                '0003_create_plan_subscriptions_table',
                '0004_create_plan_subscription_usages_table',
            ])
            ->hasCommand(LaravelSubscriptionsCommand::class);
    }
}
