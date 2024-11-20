<?php

use Soap\LaravelSubscriptions\Models\Plan;

beforeEach(function () {
    $this->plan = Plan::factory()->create();
});
