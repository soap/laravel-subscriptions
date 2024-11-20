<?php

namespace Soap\LaravelSubscriptions\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Soap\LaravelSubscriptions\Models\Feature;

/**
 * @template TModel of \Workbench\App\Plan
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class FeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
        ];
    }

    public function isConsumable($consumable): Factory
    {
        return $this->state(function (array $attributes) use ($consumable) {
            return [
                'is_consumable' => $consumable,
            ];
        });
    }

    public function isQuota($quota): self
    {
        return $this->state(function (array $attributes) use ($quota) {
            return [
                'is_quota' => $quota,
            ];
        });
    }

    public function isPostpaid($postpaid): self
    {
        return $this->state(function (array $attributes) use ($postpaid) {
            return [
                'is_postpaid' => $postpaid,
            ];
        });
    }

    public function renewable(int $period, string $interval = 'day'): self
    {
        return $this->state(fn (array $attributes) => [
            'renewable_period' => $period,
            'renewable_interval' => $interval,
        ]);
    }
}
