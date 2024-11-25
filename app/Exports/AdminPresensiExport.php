<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class AdminPresensiExport implements FromView
{
    protected $kelas;
    protected $wakel;
    protected $thajaran;
    protected $siswa;

    public function __construct($kelas, $wakel, $thajaran, $siswa)
    {
        $this->kelas = $kelas;
        $this->wakel = $wakel;
        $this->thajaran = $thajaran;
        $this->siswa = $siswa;
    }

    public function view(): View
    {
        return view('excel.presensi', [
            'kelas' => $this->kelas,
            'wakel' => $this->wakel,
            'thajaran' => $this->thajaran,
            'siswa' => $this->siswa,
        ]);
    }
}
