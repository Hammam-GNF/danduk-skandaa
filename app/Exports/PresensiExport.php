<?php
namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PresensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function collection()
    {
        return Presensi::whereHas('siswa', function($query) {
            $query->where('kelas_id', $this->kelas_id);
        })->get();    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Mata Pelajaran',
            'Total Izin',
            'Total Sakit',
            'Total Alpa',
            'Keterangan',
        ];
    }

    public function map($presensi): array
    {
        return [
            $presensi->siswa->nis,
            $presensi->siswa->nama_siswa,
            $presensi->mapel->nama_mapel, 
            $presensi->totalizin ?? '-',
            $presensi->totalsakit ?? '-',
            $presensi->totalalpa ?? '-',
            $presensi->keterangan ?? '-',
        ];
    }
}
