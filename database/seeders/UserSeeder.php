<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'username' => 'joko',
            'password' => Hash::make('joko'),
            'role_id' => 2,
            'jns_kelamin' => 'Laki-laki',
            'nip' => '123456789',
            'no_hp' => '08987456123'
        ]);
    }
}
