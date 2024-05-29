<?php

namespace Database\Seeders;

use App\Models\Rombel;
use Illuminate\Database\Seeder;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rombel::create([
            'id_rombel' => '1',
        ]);
        Rombel::create([
            'id_rombel' => '2',
        ]);
        Rombel::create([
            'id_rombel' => '3',
        ]);
        Rombel::create([
            'id_rombel' => '4',
        ]);
    }
}