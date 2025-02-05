<?php

namespace App\Http\Controllers\Admin\Result;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kelas;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\Wakel;

class TampilanAdminController extends Controller
{
    private function getTahunAjaranAktif()
    {
        return TahunAjaran::where('status', 'aktif')->first();
    }

    public function indexhasil()
    {
        $userId = auth()->user()->id;

        $kelas = Kelas::with(['wakel'])->get();  

        if ($kelas->isEmpty()) {
            return view('admin.result.daftarkelas', [
                'message' => 'Tidak ada data.',
                'kelas' => $kelas, 
                'wakel' => collect([]),
                'siswa' => collect([]),
            ]);
        }

        $pembelajaran = Pembelajaran::with(['kelas.wakel'])
            ->whereIn('kelas_id', $kelas->pluck('id')->toArray())
            ->get();

        $siswa = Siswa::whereIn('kelas_id', $kelas->pluck('id')->toArray())
            ->get();

        $wakel = Wakel::whereIn('id', $kelas->pluck('wakel.id')->filter()->toArray())->get();

        return view('admin.result.daftarkelas', compact('pembelajaran'));
    }


    public function rekapPresensi($id)
    {
        $thajaran = $this->getTahunAjaranAktif();
        $pembelajaran = Pembelajaran::find($id);
        $presensi = Presensi::where('kelas_id', $pembelajaran->kelas_id)->get();
        $kelas = $pembelajaran->kelas;

        $presensiPertama = $presensi->first();

        $kelasTitle = $kelas ? $kelas->kelas_tingkat . ' - ' . $kelas->jurusan->kode_jurusan . ' - ' . $kelas->rombel : 'Data Tidak Ditemukan';

        return view('admin.result.rekappresensi', compact('thajaran', 'presensi', 'kelas', 'kelasTitle'));
    }

    public function rekapNilai($id)
    {
        $thajaran = $this->getTahunAjaranAktif();
        $pembelajaran = Pembelajaran::find($id);
        $nilai = Nilai::where('kelas_id', $pembelajaran->kelas_id)->get();
        $kelas = $pembelajaran->kelas;

        $nilaiPertama = $nilai->first();

        $kelasTitle = $kelas ? $kelas->kelas_tingkat . ' - ' . $kelas->jurusan->kode_jurusan . ' - ' . $kelas->rombel : 'Data Tidak Ditemukan';
        
        return view('admin.result.rekapnilai', compact('thajaran', 'nilai', 'kelas', 'kelasTitle'));
    }


}
