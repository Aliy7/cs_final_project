<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodListing>
 */
class FoodListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Predefined data arrays
        $ingredients = ['Mashrooms', 'Steak', 'Salad', 'Cheese', 'Beef', 'Pizza', 'Pasta','Cheese'];
        $allergens = ['Nuts', 'Dairy', 'Shellfish', 'Soy', 'Gluten'];
     
        // $user = User::inRandomOrder()->first();
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        return [
            'name' => fake()->word,
            'ingredients' => implode(', ', fake()->randomElements($ingredients, rand(1, 3))), 
            'quantity' => fake()->randomDigitNotNull,
            'allergen' => fake()->randomElement($allergens),
        
            'description' => fake()->sentence,
            'photo_url' => fake()->imageUrl(640, 480, 'food', true),
            'status' => fake()->boolean,
            'user_id' => $user->id,
            'category_id' => $category->id, 
        ];
    }
}
