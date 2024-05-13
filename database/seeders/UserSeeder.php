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
            'username' => 'Gonjil',
            'password' => Hash::make('Gonjil'),
            'role_id' => 1,
        ]);
        User::create([
            'username' => 'Guru',
            'password' => Hash::make('Guru'),
            'role_id' => 2,
        ]);
    }
}