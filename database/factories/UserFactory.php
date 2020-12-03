<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,  
            'email' => $this->faker->unique()->safeEmail,
            'status' => true,
            'email_verified_at' => now(),
            'password' => 12345678,
            'remember_token' => Str::random(10),
        ];
    }
}
