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
                '0002_create_features_table',
                '0004_create_plans_table',
                '0006_create_plan_features_table',
                '0008_create_subscriptions_table',
                '0010_create_feature_usages_table',
            ])
            ->hasCommand(LaravelSubscriptionsCommand::class);
    }
}
