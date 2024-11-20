<?php

namespace Soap\LaravelSubscriptions\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Soap\LaravelSubscriptions\Models\PlanSubscription;

/**
 * @template TModel of \Workbench\App\Subscription
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class PlanSubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = PlanSubscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_id' => Plan::factory(),
            'name' => 'main',
        ];
    }

    public function canceled()
    {
        return $this->state(fn (array $attributes) => [
            'canceled_at' => $this->faker->dateTime(),
        ]);
    }

    public function notCanceled()
    {
        return $this->state(fn (array $attributes) => [
            'canceled_at' => null,
        ]);
    }

    public function ended()
    {
        return $this->state(fn (array $attributes) => [
            'ends_at' => $this->faker->dateTime(),
        ]);
    }

    public function notEnded()
    {
        return $this->state(fn (array $attributes) => [
            'ends_at' => now()->addDays($this->faker->randomDigitNotNull()),
        ]);
    }

    public function started()
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => $this->faker->dateTime(),
        ]);
    }

    public function notStarted()
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => $this->faker->dateTimeBetween('now', '+5 years'),
        ]);
    }
}
