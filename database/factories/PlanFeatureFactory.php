<?php

namespace Soap\LaravelSubscriptions\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Soap\LaravelSubscriptions\Models\PlanFeature;

/**
 * @template TModel of \Workbench\App\PlanFeature
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class PlanFeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = PlanFeature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->faker->numberBetween(0, 100),
            'sort_order' => 1,
        ];
    }
}
