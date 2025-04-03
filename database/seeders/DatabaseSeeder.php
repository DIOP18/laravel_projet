<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Gestionnaire',
            'email' => 'gestionnaire@gmail.com',
            'password' => Hash::make('passer123'),
            'role' => 'gestionnaire',
        ]);

        User::create([
            'name' => 'Client',
            'email' => 'clientele@gmail.com',
            'password' => Hash::make('passer123'),
            'role' => 'client',
        ]);
        // \App\Models\LivreModel::factory(20)->create();
        $this->call([
            LivreModelSeeder::class,

        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
