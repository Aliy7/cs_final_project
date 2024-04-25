<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $firstNames = ['Emma', 'Liam', 'Olivia', 'Noah', 'Ava', 'William', 'Isabella', 'James', 'Sophia', 'Logan'];
        $lastNames = ['Smith', 'Johnson', 'Brown', 'Taylor', 'Wilson', 'Martinez', 'Anderson', 'Miller', 'Davis', 'Garcia'];
        $password = Str::random(10); 

        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->userName . '@swansea.ac.uk',
            'first_name' => $this->faker->randomElement($firstNames),
            'last_name' => $this->faker->randomElement($lastNames),
            'phone_number' => '07' . $this->faker->numberBetween(100, 999) . $this->faker->numberBetween(1000000, 9999999), // Ensure 11 digits
            'email_verified_at' => now(),
            'password' => Hash::make($password), 
            'remember_token' => Str::random(10),
                // 'username' => fake()->name(),
                // 'email' => fake()->unique()->safeEmail(),
                // 'first_name' => fake()->name(),
                // 'last_name' => fake()->name(),
                // 'phone_number' => fake()->phoneNumber(),
                // 'email_verified_at' => now(),
                // 'password' => static::$password ??= Hash::make('password'),
                // 'remember_token' => Str::random(10),
            ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
