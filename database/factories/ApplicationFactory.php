<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Address;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    private static $userId = 17; 

    public function definition(): array
    {
        $firstNames = ['James', 'Emma', 'William', 'Noah', 'Sophia', 'Ava', 'Logan', 'Olivia'];
        $lastNames = ['Smith', 'Martinez', 'Brown', 'Wilson', 'Miller', 'Taylor', 'Johnson', 'Wilson'];
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'user_id' => $user->id,
            'family_income' => fake()->numberBetween(21000, 33000),
            'name' => fake()->randomElement($firstNames) . ' ' . fake()->randomElement($lastNames),
            'is_student' => fake()->boolean(),
            'status' => fake()->randomElement(['approved', 'pending']),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Application $application) {
            $address = Address::factory()->create([
                'user_id' => $application->user_id, 
            ]);
            $application->address_id = $address->id;
        });
    }
}
