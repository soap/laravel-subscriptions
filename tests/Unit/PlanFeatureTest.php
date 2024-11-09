<?php

use Soap\LaravelSubscriptions\Models\Plan;
use Soap\LaravelSubscriptions\Models\PlanFeature;

beforeEach(function () {
    $this->plan = Plan::factory()->create();
});

it('can add feature to plan', function () {
    $feature = PlanFeature::factory()->make();

    $this->plan->features()->save($feature);

    expect($this->plan->features->count())->toBe(1);
    expect($this->plan->features->first()->name)->toBe($feature->name);
});

it('can add more features to plan', function () {
    $feature = PlanFeature::factory()->make(['name' => 'number of users', 'value' => 10]);

    $otherFeature = PlanFeature::factory()->make(['name' => 'number of leave requests', 'value' => 10]);
    $this->plan->features()->saveMany([$feature, $otherFeature]);

    expect($this->plan->features()->count())->toBe(2);
    expect($this->plan->features()->latest()->first()->name)->toBe($otherFeature->name);
    expect($this->plan->features()->latest()->first()->sort_order)->toBe(2);

    $this->plan->features()->create(['name' => 'number of departments', 'value' => 10]);
    expect($this->plan->features()->count())->toBe(3);
    expect($this->plan->features()->latest()->first()->name)->toBe('number of departments');
    expect($this->plan->features()->latest()->first()->sort_order)->toBe(3);
});
