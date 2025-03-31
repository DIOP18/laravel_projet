<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LivreModel>
 */
class LivreModelFactory extends Factory
{
    protected $model = LivreModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre'=> $this->faker->sentence(),
            'auteur'=> $this->faker->name(),
            'prix'=> $this->faker->randomFloat(),
            'image'=> $this->faker->imageUrl(),
            'nationalite'=> $this->faker->country(),
            'description'=> $this->faker->paragraph(),
            'Stockdisponible'=> $this->faker->randomFloat(),
            //
        ];
    }
}
