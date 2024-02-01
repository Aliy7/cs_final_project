<?php

namespace Database\Seeders;

use App\Models\FoodListing;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FoodListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FoodListing::factory()->count(20)->create();
    }
}
