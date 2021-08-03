<?php

namespace App\Containers\Settings\Domain\Factories;

use App\Containers\Settings\Domain\Entities\Settings;
use App\Ship\Apiato\Abstracts\Factories\Factory;

class SettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Settings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->word,
            'fields' => [],
        ];
    }
}
