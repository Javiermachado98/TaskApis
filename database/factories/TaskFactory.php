<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SebastianBergmann\CodeUnit\TraitUnit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo'=>fake()->words(3,true),
            'descripcion'=>fake()->sentence(5),
            'estado'=>fake()->boolean(),
            'prioridad'=>fake()->numberBetween(1,5),
        ];
    }
}
