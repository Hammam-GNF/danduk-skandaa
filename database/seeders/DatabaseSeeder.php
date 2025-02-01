<?php

namespace Database\Seeders;

use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\User;
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

        $startYear = 2021;
        $currentYear = now()->year;
        $tahunAjaranList = [];
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $tahunAjaranList[] = $year . '/' . ($year + 1);
        }
        $totalTahunAjaran = count($tahunAjaranList);
        foreach ($tahunAjaranList as $index => $thajaran) {
            if ($index === ($totalTahunAjaran - 1)) {
                TahunAjaran::create([
                    'thajaran' => $thajaran,
                    'semester' => 'Ganjil',
                    'status' => 'aktif',
                ]);
                TahunAjaran::create([
                    'thajaran' => $thajaran,
                    'semester' => 'Genap',
                    'status' => 'nonaktif',
                ]);
            } else {
                TahunAjaran::create([
                    'thajaran' => $thajaran,
                    'semester' => 'Ganjil',
                    'status' => 'nonaktif',
                ]);
                TahunAjaran::create([
                    'thajaran' => $thajaran,
                    'semester' => 'Genap',
                    'status' => 'nonaktif',
                ]);
            }
        }

        $mataPelajaran = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Pendidikan Pancasila',
            'Pendidikan Agama',
            'Sejarah Indonesia',
            'PJOK',
            'Seni Budaya',
            'Informatika',
            'Gambar Teknik',
            'Teknik Pemesinan Dasar',
            'Teknik Pengelasan',
            'Dasar Listrik dan Elektronika',
            'Dasar Desain Pemodelan Bangunan',
            'Teknik Kendaraan Ringan',
            'Nautika Kapal Penangkap Ikan',
            'Teknik Instalasi Tenaga Listrik',
            'Teknik Pembangkit Tenaga Listrik',
            'Bisnis Konstruksi dan Properti'
        ];

        Jurusan::factory(5)->create(); //create jurusan

        $jumlahKelas = Kelas::count();
        Kelas::factory(5 * 3 * 4)->create(); //create kelas

        Mapel::factory(count($mataPelajaran))->create(); //create mapel

        $jumlahGuru = User::where('role_id', 4)->count();

        $guruBaru = User::factory(30)->create(['role_id' => 4]); //create guru

        $guruUntukWakel = User::where('role_id', 4)->inRandomOrder()->limit(20)->get();
        $guruUntukWakel->each(function ($guru) {
            $guru->update(['role_id' => 3]);
        });
        $kelasList = Kelas::all();

        $wakelCount = min($guruUntukWakel->count(), $kelasList->count());

        $guruUntukWakel->take($wakelCount)->each(function ($guru, $index) use ($kelasList) {
            Wakel::create([
                'user_id' => $guru->id, 
                'kelas_id' => $kelasList[$index]->id,
            ]);
        });

        //create siswa
        Kelas::all()->each(function ($kelas) {
            Siswa::factory(32)->create([
                'kelas_id' => $kelas->id,
            ]);
        });
    }
}