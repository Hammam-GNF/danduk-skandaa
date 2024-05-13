<?php

namespace Database\Seeders;

use App\Models\Rombel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rombel::create([
            'id' => '1',
            'nama_rombel' => '1',
        ]);
        Rombel::create([
            'id' => '2',
            'nama_rombel' => '2',
        ]);
        Rombel::create([
            'id' => '3',
            'nama_rombel' => '3',
        ]);
        Rombel::create([
            'id' => '4',
            'nama_rombel' => '4',
        ]);
    }
}