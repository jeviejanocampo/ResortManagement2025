<?php

namespace Database\Factories;

use App\Models\OptionCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OptionCategory>
 */
class OptionCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OptionCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('is_owner', true)->first()->id,
            'name' => $this->faker->sentence(3),
            'status' => 'active',
            'created_at' => now(),
        ];
    }
}