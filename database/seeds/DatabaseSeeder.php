<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Flagstudio',
            'email' => 'forspam@flagstudio.ru',
            'password' => bcrypt('123123'), // secret
             'email_verified_at' => now()
            // 'remember_token' => str_random(10),
        ]);
    }
}
