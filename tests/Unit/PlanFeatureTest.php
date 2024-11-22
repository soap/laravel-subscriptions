<?php

use Soap\LaravelSubscriptions\Models\Feature;
use Soap\LaravelSubscriptions\Models\Plan;
use Soap\LaravelSubscriptions\Models\PlanFeature;

beforeEach(function () {
    $this->plan = Plan::factory()->create();
    $this->feature = Feature::factory()->create();
});

it('planFeature can retrieve a plan', function () {

    $this->plan->features()->attach($this->feature);

    $planFeaturePivot = PlanFeature::first();

    expect($planFeaturePivot->plan->id)->toBe($this->plan->id);
});

it('planFeature can retrieve a feature', function () {

    $this->plan->features()->attach($this->feature);

    $planFeaturePivot = PlanFeature::first();

    expect($planFeaturePivot->feature->id)->toBe($this->feature->id);
});
