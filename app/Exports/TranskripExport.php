<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TranskripExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    protected $kelas;
    protected $siswa;

    public function __construct($kelas, $siswa)
    {
        $this->kelas = $kelas;
        $this->siswa = $siswa;
    }

    public function collection()
    {
        return $this->siswa;
    }

    public function headings(): array
    {
        $headings = ['No', 'Nama Siswa'];

        foreach ($this->kelas->pembelajaran as $pembelajaran) {
            $headings[] = $pembelajaran->mapel->nama_mapel;
        }

        array_push($headings, 'Average', 'Grade');

        return $headings;
    }

    public function map($siswa): array
    {
        $row = [];
        $row[] = $this->siswa->search($siswa) + 1;
        $row[] = $siswa->nama_siswa;

        $totalAverage = 0;
        $subjectCount = $this->kelas->pembelajaran->count();

        foreach ($this->kelas->pembelajaran as $pembelajaran) {
            $nilaiSiswa = $pembelajaran->nilai->firstWhere('nis', $siswa->nis);
            $average = $nilaiSiswa != null ?
                $nilaiSiswa->uh1 * 0.15 +
                $nilaiSiswa->uh2 * 0.15 +
                $nilaiSiswa->uh3 * 0.15 +
                $nilaiSiswa->uts * 0.25 +
                $nilaiSiswa->uas * 0.3
                : 0;
            $totalAverage += $average;

            $row[] = $average ? number_format($average, 2) : '-';
        }

        $overallAverage = $subjectCount ? $totalAverage / $subjectCount : 0;
        $row[] = $subjectCount ? number_format($totalAverage / $subjectCount, 2) : '-';
        $row[] = $this->getGrade($overallAverage);

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);
        $sheet->getStyle('A:Z')->getAlignment()->setHorizontal('center');
    }

    private function getGrade($average)
    {
        if ($average >= 90) {
            return 'A';
        } elseif ($average >= 80) {
            return 'B';
        } elseif ($average >= 70) {
            return 'C';
        } else {
            return 'D';
        }
    }
}
