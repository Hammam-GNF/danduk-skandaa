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
            'username' => 'mimin',
            'password' => Hash::make('mimin'),
            'role_id' => 1,
            'jns_kelamin' => 'Laki-laki',
            'nip' => '210302080',
            'no_hp' => '081234567890'
        ]);
    }
}
