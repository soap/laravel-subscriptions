<?php

use Soap\LaravelSubscriptions\Models\Feature;

it('can generate feature using factory', function () {
    $feature = Feature::factory()->create();
    ray($feature);
    expect($feature->name)->toBeString();
    expect($feature->description)->toBeString();
    expect($feature->slug)->toBeString();
});

it('can generate customized attributes of feature using factory', function () {
    $feature = Feature::factory()
        ->notConsumable()
        ->prepaid()
        ->create();

    expect($feature->name)->toBeString();
    expect($feature->description)->toBeString();
    expect($feature->is_consumable)->toBeFalse();
    expect($feature->is_quota)->toBeFalse();
    expect($feature->is_postpaid)->toBeFalse();
});
