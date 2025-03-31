<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class livrefactoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image'=> $this->faker->imageUrl(),
            'titre'=> $this->faker->sentence(),
            'description'=> $this->faker->paragraph(),
            'prix'=> $this->faker->randomFloat(),
            'auteur'=> $this->faker->name(),
            'nationalite'=> $this->faker->country(),
            'Stockdisponible'=> $this->faker->randomFloat(),
            //
        ];
    }
}
