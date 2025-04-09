<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => $this->faker->randomElement(User::where('role', 'customer')->pluck('id')->toArray()),
            'title' => $this->faker->sentence(3),
            'freelancer_id' => $this->faker->randomElement(User::where('role', 'freelancer')->pluck('id')->toArray()),
            'category' => $this->faker->randomElement(Category::pluck('category')->toArray()),
            'description' => $this->faker->paragraph(3),
            'budget_min' => $this->faker->numberBetween(100, 1000),
            'budget_max' => $this->faker->numberBetween(1000, 10000),
            'deadline' => $this->faker->numberBetween(1, 30),
            'status' => $this->faker->randomElement(['open', 'in progress', 'completed']),
        ];    
    }
}
