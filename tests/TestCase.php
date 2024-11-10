<?php

namespace Soap\LaravelSubscriptions\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Workbench\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
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
