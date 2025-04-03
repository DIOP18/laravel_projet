<?php

namespace Database\Seeders;

use App\Models\LivreModel;
use Illuminate\Database\Seeder;

class LivreModelSeeder extends Seeder
{
    public function run(): void
    {
        LivreModel::factory()
            ->count(20)
            ->create();
    }
}
