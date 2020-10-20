<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function run()
    {
        if (!config('app.admin_password')) {
            throw new \Exception('Environment variable ADMIN_PASSWORD is required. You can set it in .env file');
        }

        User::factory()->create([
            'name' => 'Flagstudio',
            'email' => 'forspam@flagstudio.ru',
            'password' => bcrypt(config('app.admin_password')), // secret
            'email_verified_at' => now(),
        ]);
    }
}
