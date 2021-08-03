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
            'phone' => $this->faker->e164PhoneNumber,
            'birth' => $this->faker->date(),
        ];
    }
}
