<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new RoleSeeder)->run();

        \App\Models\User::factory()->create([
            'name' => 'Roman Khabibulin',
            'email' => 'roman.khabibulin12@gmail.com',
            'password' => Hash::make('admin'),
            'role_id' => \App\Models\Role::where('name', 'admin')->first()->id,
            'age' => 18,
            'sex' => 'M'
        ]);

        (new ProductSeeder)->run();
    }
}
