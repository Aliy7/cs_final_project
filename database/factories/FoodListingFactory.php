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
        $ingredients = ['Mashrooms', 'Steak', 'Salad', 'Cheese', 'Beef', 'Pizza', 'Pasta','Cheese', 'Flour', 'Water'];
        $allergens = ['Nuts', 'Dairy', 'Shellfish',  'Soy', 'Gluten', 'Eggs', 'Peanuts',  'Fish', 'Sesame',
         'Mustard', 'Celery',  'Lupin',  'Mollusks', 'Sulphur Dioxide (Sulphites)' 
        ];
        $name = ['Pizza', 'Burger', 'Steak', 'Pasta', 'Sandwich', 'Salad', 'Cheese', 'Tacos', 'Burrito',
        'Lasagna', 'Spaghetti', 'Meatloaf', 'Fried Chicken', 'Waffles', 'Pancakes', 'Macaroni and Cheese',
        'BBQ Ribs', 'Hot Dog', 'Grilled Cheese', 'Pot Pie', 'Clam Chowder', 'Bagel', 'French Fries',
        'Nachos', 'Cobb Salad', 'Reuben Sandwich', 'Potato Salad', 'Biscuits and Gravy', 'Cornbread',
        'Apple Pie', 'Buffalo Wings', 'Sloppy Joes', 'Caesar Salad', 'Fajitas', 'Fish and Chips',
        'Beef Stroganoff', 'Corn Dog', 'Jambalaya', 'Gumbo', 'Chili', 'Quiche', 'French Toast',
        'Baked Beans', 'Deviled Eggs', 'Meatballs', 'Chicken Soup', 'Omelette', 'Stuffed Peppers',
        'Brisket', 'Turkey', 'Mashed Potatoes', 'Gravy', 'Roast Beef', 'Shepherd Pie',
        'Chicken Pot Pie', 'Ratatouille', 'Beef Wellington', 'Stew', 'Grits', 'Baked Potato'];
       
        $descriptions = [
            'Nuts' => 'Allergy to various tree nuts like almonds, walnuts, cashews, etc.',
            'Dairy' => 'Allergy to proteins found in cow\'s milk and dairy products.',
            'Shellfish' => 'Allergy to crustaceans like shrimp, crab, and lobster.',
            'Soy' => 'Allergy to a type of legume (soybeans).',
            'Gluten' => 'Allergy to a protein (gluten) found in wheat, rye, and barley.',
            'Eggs' => 'Allergy to proteins found in chicken eggs.',
            'Peanuts' => 'Allergy to a type of legume, often severe.',
            'Fish' => 'Allergy to finned fish like salmon, tuna, and cod.',
            'Sesame' => 'Allergy to sesame seeds and sesame products.',
            'Mustard' => 'Allergy to mustard seeds, often found in condiments and sauces.',
            'Celery' => 'Allergy to celery stalks, leaves, seeds, and root (celeriac).',
            'Lupin' => 'Allergy to a legume common in some European products.',
            'Mollusks' => 'Allergy to clams, oysters, scallops, mussels, etc.',
            'Sulphur Dioxide (Sulphites)' => 'Sensitivity to preservatives used in wine, dried fruits, etc.' 
        ];

        $allergen = fake()->randomElement($allergens);

        // Get the corresponding description for the selected allergen
        $description = $descriptions[$allergen];
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        return [
            'name' => fake()->randomElement($name),
            'ingredients' => implode(', ', fake()->randomElements($ingredients, rand(1, 3))), 
            'quantity' => fake()->randomDigitNotNull,
            'allergen' => $allergen,  
            'description' => $description,  
            'photo_url' => fake()->imageUrl(640, 480, 'food', true),
            'status' => fake()->boolean,
            'user_id' => $user->id,
            'category_id' => $category->id, 
        ];
    }
}
