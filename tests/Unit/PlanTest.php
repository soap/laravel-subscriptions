<?php

use Soap\LaravelSubscriptions\Models\Plan;

it('can generate plan using factory', function () {
    $plan = Plan::factory()->create();

    expect($plan->name)->toBeString();
    expect($plan->description)->toBeString();
    expect($plan->price)->toBeFloat();
    expect($plan->currency)->toBe('THB');
    expect($plan->trial_interval)->toBe('day');
    expect($plan->trial_period)->toBe(0);
    expect($plan->sort_order)->toBe(1);
});
