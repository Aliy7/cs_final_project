<?php

namespace Database\Seeders;

use App\Models\HelpContent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HelpContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HelpContent::factory()->count(10)->create(); 
      
    }
}
