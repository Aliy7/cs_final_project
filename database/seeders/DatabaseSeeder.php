<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\FoodListingFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call(RolePermissionSeeder::class);
       $this->call(UserSeeder::class);
       $this->call(ProfileSeeder::class);
       $this->call(FoodListingSeeder::class);
       $this->call(CategorySeeder::class);
       $this->call(AddressSeeder::class);
       $this->call(HelpContentSeeder::class);
       $this->call(ApplicationSeeder::class);
    }
}
