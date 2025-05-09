<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'firstname' => 'Ceorl',
                'lastname' => 'Tzy',
                'is_superuser' => true,
                'email' => 'ceorl@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
            [
                'firstname' => 'Owner',
                'lastname' => 'Owner',
                'is_owner' => true,
                'email' => 'owner@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
            [
                'firstname' => 'Staff',
                'lastname' => 'Staff',
                'is_staff' => true,
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ]
        ]);
    }
}
