<?php

namespace Database\Seeders;

use App\Containers\Settings\Domain\Seeders\SettingsSeeder;
use App\Containers\User\Domain\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
