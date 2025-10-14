<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'role' => 'student',
            'nis' => $this->faker->unique()->numerify('NIS###'),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'class_id' => null,
            'specialization' => null,
        ];
    }
}
