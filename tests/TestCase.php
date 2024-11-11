<?php

namespace Soap\LaravelSubscriptions\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Soap\LaravelSubscriptions\LaravelSubscriptionsServiceProvider;

#[WithMigration]
class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            if (Str::startsWith($modelName, 'Workbench\\App\\Models\\')) {
                // Factories within the tests directory
                return 'Workbench\\Database\\Factories\\'.class_basename($modelName).'Factory';
            }

            return 'Soap\\LaravelSubscriptions\\Database\\Factories\\'.class_basename($modelName).'Factory';
        });

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations'); // load the package migrations
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSubscriptionsServiceProvider::class,
        ];
    }

    protected function usesMySqlConnection($app)
    {
        $app['config']->set('database.default', 'mysql');
    }
}
