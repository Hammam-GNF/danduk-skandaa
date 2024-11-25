<?php

namespace Database\Seeders;

use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Wakel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        TahunAjaran::factory(5)->create();
        Jurusan::factory(20)->create();
        Mapel::factory(20)->create();
        Kelas::factory(20)->create();
        Wakel::factory(12)->create();
        Siswa::factory(800)->create();
    }
}