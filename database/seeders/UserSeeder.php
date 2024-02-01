<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'Dev',
            'role' => 'admin',
            'email' => 'dev@app.com',
            'password' => Hash::make('password'),
        ]);
    }
}
