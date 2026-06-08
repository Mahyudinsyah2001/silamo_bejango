<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin'
            ]
        );

        \App\Models\User::firstOrCreate(

            ['email' => 'adminlapassumbawa@gmail.com'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin'
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'mahyudinsyah41@gmail.com'],
            [
                'name' => 'Mahyu',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin'
            ]
        );
    }
}
