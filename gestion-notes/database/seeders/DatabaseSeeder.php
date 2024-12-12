<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur de test
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Simuler la connexion de l'utilisateur
        Auth::login($user); // Simule la connexion pour le seeder

        // Créer des catégories fictives
        $categories = Category::factory()->count(10)->create();

        // Créer des notes fictives avec l'utilisateur connecté
        Note::factory()
            ->count(50)
            ->create(['user_id' => Auth::id(), 'category_id' => $categories->random()->id]);
    }
}
