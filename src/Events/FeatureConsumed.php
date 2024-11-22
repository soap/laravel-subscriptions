<?php

namespace Soap\LaravelSubscriptions\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Soap\LaravelSubscriptions\Models\Feature;
use Soap\LaravelSubscriptions\Models\FeatureUsage;

class FeatureConsumed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public $subscriber,
        public Feature $feature,
        public FeatureUsage $usage,
    ) {}
}
