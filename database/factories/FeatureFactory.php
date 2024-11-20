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
            'is_consumable' => $this->faker->boolean(),
            'renewable_period' => $this->faker->randomDigitNotZero(),
            'renewable_interval' => $this->faker->randomElement([
                'year',
                'month',
                'week',
                'day',
            ]),
            'is_quota' => false,
            'is_postpaid' => false,
        ];
    }

    public function consumable(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_consumable' => true,
            ];
        });
    }

    public function notConsumable(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_quota' => false,
            'is_consumable' => false,
            'renewable_period' => null,
            'renewable_interval' => null,
        ]);
    }

    public function quota(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_consumable' => true,
            'is_quota' => true,
            'renewable_period' => null,
            'renewable_interval' => null,
        ]);
    }

    public function notQuota(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_quota' => false,
        ]);
    }

    public function prepaid(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_postpaid' => false,
        ]);
    }

    public function postpaid(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_postpaid' => true,
        ]);
    }

    public function renewable(int $period, string $interval = 'day'): self
    {
        return $this->state(fn (array $attributes) => [
            'renewable_period' => $period,
            'renewable_interval' => $interval,
        ]);
    }
}
