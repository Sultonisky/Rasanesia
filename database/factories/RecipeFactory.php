<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'ingredients' => collect($this->faker->words(6))->implode(", "),
            'steps' => $this->faker->paragraphs(3, true),
            'foto' => 'recipes/' . $this->faker->image('storage/recipes', 640, 480, null, false),

        ];
    }
}
