<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        return [
             'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
             'bio' => fake()->sentence,
             'phone_number' => fake()->phoneNumber,
             'date_of_birth' => fake()->date($format='Y-m-d', $max='now'),
             'image_url' => fake()->imageUrl(),

         ];   
    }
}
