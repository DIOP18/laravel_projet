<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LivreModelFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Roman', 'Science-Fiction', 'Fantasy', 'Policier', 'Biographie', 'Histoire'];

        return [
            'titre' => $this->faker->randomElement([
                    'Le Secret des Anciens',
                    'La Prophétie Oubliée',
                    'Les Ombres de la Cité',
                    'Le Dernier Royaume',
                    'L\'Épée de Vérité',
                    'Les Chroniques du Nord',
                    'Le Labyrinthe des Rêves',
                    'La Pierre Éternelle'
                ]).' '.$this->faker->randomElement(['Tome 1', 'Tome 2', '']),
            'auteur' => $this->faker->name,
            'prix' => $this->faker->numberBetween(500, 5000),
            'image' => 'livre-'.$this->faker->image() ,
        'description' => $this->faker->paragraphs(3, true),
            'Stockdisponible' => $this->faker->numberBetween(0, 50),
            'categorie' => $this->faker->randomElement($categories),
            'archived' => $this->faker->boolean(10), // 10% de chance d'être archivé
            'created_at' => $this->faker->dateTimeBetween('-2 years'),
        ];
    }
}
