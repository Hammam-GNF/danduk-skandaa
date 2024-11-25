<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function collection()
    {
        return Nilai::whereHas('siswa', function($query) {
            $query->where('kelas_id', $this->kelas_id);
        })->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Mata Pelajaran',
            'Rata-Rata',
            'Predikat'
        ];
    }

    public function map($nilai): array
    {
        $rata_rata = ($nilai->uh1 + $nilai->uh2 + $nilai->uh3 + $nilai->uts + $nilai->uas) / 5;
        $predikat = '';
        if ($rata_rata >= 85) {
            $predikat = 'A';
        } elseif ($rata_rata >= 75) {
            $predikat = 'B';
        } elseif ($rata_rata >= 60) {
            $predikat = 'C';
        } else {
            $predikat = 'D';
        }

        return [
            $nilai->siswa->nis,
            $nilai->siswa->nama_siswa,
            $nilai->mapel->nama_mapel,
            $rata_rata,
            $predikat,
        ];
    }
}
