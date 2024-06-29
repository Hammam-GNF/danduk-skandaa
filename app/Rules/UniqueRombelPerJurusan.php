<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Kelas;

class UniqueRombelPerJurusan implements Rule
{
protected $kelas_tingkat;
protected $jurusan_id;

public function __construct($kelas_tingkat, $jurusan_id)
{
$this->kelas_tingkat = $kelas_tingkat;
$this->jurusan_id = $jurusan_id;
}

public function passes($attribute, $rombel)
{
// Cek apakah ada record dengan kombinasi yang sama
$count = Kelas::where('kelas_tingkat', $this->kelas_tingkat)
->where('jurusan_id', $this->jurusan_id)
->where('rombel', $rombel)
->count();

// Valid jika tidak ada record yang sama
return $count === 0;
}

public function message()
{
return 'Rombel sudah ada untuk kombinasi kelas_tingkat dan jurusan_id yang sama.';
}
}