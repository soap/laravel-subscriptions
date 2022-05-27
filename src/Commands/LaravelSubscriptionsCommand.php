<?php

namespace Soap\LaravelSubscriptions\Commands;

use Illuminate\Console\Command;

class LaravelSubscriptionsCommand extends Command
{
    public $signature = 'laravel-subscriptions';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
