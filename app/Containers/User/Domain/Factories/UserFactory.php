<?php

namespace App\Containers\User\Domain\Factories;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Apiato\Abstracts\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '+79' . rand(100000000, 999999999),
            'birth' => $this->faker->date(),
        ];
    }
}
