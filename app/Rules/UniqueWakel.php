<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin\Kelas;

class UniqueWakel implements Rule
{
    protected $kelas_tingkat;
    protected $jurusan_id;
    protected $rombel;
    protected $thajaran_id;
    protected $current_id;

    public function __construct($kelas_tingkat, $jurusan_id, $rombel, $thajaran_id, $current_id = null)
    {
        $this->kelas_tingkat = $kelas_tingkat;
        $this->jurusan_id = $jurusan_id;
        $this->rombel = $rombel;
        $this->thajaran_id = $thajaran_id;
        $this->current_id = $current_id;
    }

    public function passes($attribute, $value)
    {
        $query = Kelas::where('kelas_tingkat', $this->kelas_tingkat)
            ->where('jurusan_id', $this->jurusan_id)
            ->where('rombel', $this->rombel)
            ->where('thajaran_id', $this->thajaran_id)
            ->where('wakel_id', $value);

        if ($this->current_id) {
            $query->where('id', '<>', $this->current_id);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'Wali kelas ini sudah digunakan untuk kelas lain.';
    }
}
