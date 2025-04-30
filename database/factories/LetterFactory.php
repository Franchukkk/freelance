<?php

namespace Database\Factories;

use App\Models\Letter;
use App\Models\User;
use App\Enums\LetterStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class LetterFactory extends Factory
{
    protected $model = Letter::class;

    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'status' => LetterStatusEnum::Pending->value, // статус за замовченням
            'manager_id' => null,
            'answer' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withManager(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'manager_id' => User::factory(), // Прив'язка менеджера
            ];
        });
    }
}
