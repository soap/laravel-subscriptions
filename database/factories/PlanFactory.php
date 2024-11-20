<?php

namespace Soap\LaravelSubscriptions\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Soap\LaravelSubscriptions\Models\Plan;

/**
 * @template TModel of \Workbench\App\Plan
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(asText: true),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'currency' => 'THB',
            'invoice_interval' => 'month',
            'invoice_period' => 1,
            'trial_period' => 0,
            'trial_interval' => 'day',
        ];
    }

    public function withTrialPeriod(int $count, ?string $unit = null): self
    {
        return $this->state(fn (array $attributes) => [
            'trial_period_days' => $count,
            'trial_interval' => $unit ?? 'day',
        ]);
    }

    public function withGracePeriod(int $count, ?string $unit = null): self
    {
        return $this->state(fn (array $attributes) => [
            'trial_period_days' => $count,
            'trial_interval' => $unit ?? 'day',
        ]);
    }

    public function withSignUpFee(float $fee): self
    {
        return $this->state(fn (array $attributes) => [
            'signup_fee' => $fee,
        ]);
    }
}
