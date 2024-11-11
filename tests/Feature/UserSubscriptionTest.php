<?php

use Soap\LaravelSubscriptions\Models\Plan;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->plan = Plan::factory()->create();
    $this->user = User::factory()->create();
});

test('User model implements subscription methods', function (): void {
    expect($this->user)
        ->toHaveMethods([
            'activePlanSubscriptions',
            'planSubscription',
            'planSubscriptions',
            'newPlanSubscription',
            'subscribedPlans',
            'subscribedTo',
        ]);
});
/*
test('User can subscribe to a plan', function () {

    $this->user->newPlanSubscription('main', $this->plan);

    expect($this->user->subscribedTo($this->plan->id))
        ->toBeTrue()
        ->and($this->user->subscribedPlans()->count())
        ->toBe(1);
});
*/
