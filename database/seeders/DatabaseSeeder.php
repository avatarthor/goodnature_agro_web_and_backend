<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@goodnatureagro.com',
                'name' => 'Kauma Mbewe',
                'password' => \Hash::make('hd83b9@(*DBD@'),
            ]);
    }
}
