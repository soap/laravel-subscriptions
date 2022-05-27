<?php

namespace Soap\LaravelSubscriptions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Soap\LaravelSubscriptions\LaravelSubscriptions
 */
class LaravelSubscriptions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-subscriptions';
    }
}
