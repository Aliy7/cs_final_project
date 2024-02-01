<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodListing;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory()->count(20)->create();
        FoodListing::all()->each(function ($foodlisting) use ($categories) {
        $foodlisting->update(['category_id' => $categories->random()->id]);
     });
    }
}
