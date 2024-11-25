<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin\Kelas;

class UniqueKelasCombination implements Rule
{
    protected $current_id;

    public function __construct($current_id = null)
    {
        $this->current_id = $current_id;
    }

    public function passes($attribute, $value)
    {
        $query = Kelas::where('kelas_tingkat', request()->input('kelas_tingkat'))
            ->where('jurusan_id', request()->input('jurusan_id'))
            ->where('rombel', request()->input('rombel'));

        if ($this->current_id) {
            $query->where('id', '<>', $this->current_id);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'Kombinasi kelas tingkat, jurusan, dan rombel sudah ada.';
    }
}
