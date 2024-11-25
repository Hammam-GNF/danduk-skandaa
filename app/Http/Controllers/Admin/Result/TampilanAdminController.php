<?php

namespace App\Http\Controllers\Admin\Result;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        $pembelajaran = Pembelajaran::with(['kelas.wakel'])
        ->whereIn('kelas_id', $kelas->pluck('id')->toArray())
        ->get();

        $kelasIds = $kelas->pluck('id')->toArray();
        $wakelIds = $kelas->pluck('wakel.id')->filter()->toArray();

        $wakel = Wakel::whereIn('id', $wakelIds)->get();
        
        $siswa = Siswa::whereIn('kelas_id', $kelasIds)
        ->where('thajaran_id', $tahunAjaranAktif->id)
        ->get();

        return view('admin.result.daftarkelas', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }

    public function rekapPresensi($id)
    {
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        $presensi = Presensi::where('kelas_id', $id)->get();

        $presensiPertama = $presensi->first();

        $kelas = $presensiPertama ? $presensiPertama->kelas : null;
        
        return view('admin.result.rekappresensi', compact('thajaran', 'presensi', 'kelas'));
    }

    public function rekapNilai($id)
    {
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        $nilai = Nilai::where('kelas_id', $id)->get();

        $nilaiPertama = $nilai->first();

        $kelas = $nilaiPertama ? $nilaiPertama->kelas : null;
        
        return view('admin.result.rekapnilai', compact('thajaran', 'nilai', 'kelas'));
    }


}
