<?php

use Soap\LaravelSubscriptions\Models\Feature;
use Soap\LaravelSubscriptions\Models\Plan;
use Spatie\TestTime\TestTime;
use Workbench\App\Models\User;

beforeEach(function () {
    TestTime::freeze('Y-m-d H:i:s', '2024-11-01 00:00:01');
    $this->plan = Plan::factory()->create();
    $this->user = User::factory()->create();

    Feature::create([
        'name' => 'employee count',
        'is_consumable' => true,
        'is_quota' => true,
    ]);

    Feature::create([
        'name' => 'leave request count',
        'is_consumable' => true,
        'renewable_period' => 1,
        'renewable_interval' => 'month',
    ]);
});

test('user model implements subscription methods', function (): void {
    expect($this->user)
        ->toHaveMethods([
            'activeSubscriptions',
            'subscription',
            'subscriptions',
            'newSubscription',
            'subscribedPlans',
            'subscribedTo',
        ]);
});

test('user can subscribe to plan', function () {
    $this->user->newSubscription('main', $this->plan);

    expect($this->user->subscribedTo($this->plan->id))
        ->toBeTrue()
        ->and($this->user->subscribedPlans()->count())
        ->toBe(1);
});

test('user can have a monthly active subscription plan', function (): void {
    $this->user->newSubscription('main', $this->plan);

    expect($this->user->subscription('main')->active())
        ->toBeTrue()
        ->and($this->user->subscription('main')->ends_at->toDateString())
        ->toBe(Carbon\Carbon::now()->addMonth()->addDays($this->plan->trial_period)->toDateString());
});
