<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Application;
use App\Models\Address;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    private static $userId = 17; 

    public function definition(): array
    {
        $firstNames = ['James', 'Emma', 'William', 'Noah', 'Sophia', 'Ava', 'Logan', 'Olivia'];
        $lastNames = ['Smith', 'Martinez', 'Brown', 'Wilson', 'Miller', 'Taylor', 'Johnson', 'Wilson'];

        return [
            'user_id' => self::$userId++,
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
