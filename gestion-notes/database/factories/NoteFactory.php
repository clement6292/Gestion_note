<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Auth::id(), // Crée un utilisateur fictif
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category_id' => Category::factory(), // Associer une catégorie fictive
            'image_path' => $this->faker->imageUrl(),
        ];
    }
}
