<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['level' => 'Admin'], ['level' => 'Admin']);
        Role::updateOrCreate(['level' => 'Kepala Sekolah'], ['level' => 'Kepala Sekolah']);
        Role::updateOrCreate(['level' => 'Wali Kelas'], ['level' => 'Wali Kelas']);
        Role::updateOrCreate(['level' => 'Guru'], ['level' => 'Guru']);
    }
}