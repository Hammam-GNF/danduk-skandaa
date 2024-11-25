<?php

namespace App\Http\Controllers\Admin\Result;

use App\Exports\PresensiExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Admin\Pembelajaran;
use App\Models\Wakel;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{

    private function getTahunAjaranAktif()
    {
        return TahunAjaran::where('status', 'aktif')->first();
    }

    public function indexpresensi()
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

        return view('admin.result.presensi', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }
    // public function indexpresensi()
    // {
    //     $kelas = Kelas::with('jurusan')->get();
    //     $thajaran = TahunAjaran::where('status', 'aktif')->first();
    //     if (!$thajaran) {
    //         $thajaran = (object)[
    //             'id' => null,
    //             'thajaran' => 'Tidak ada tahun ajaran aktif',
    //             'semesterLabel' => ''
    //         ];
    //     }
    //     $pembelajaran = Pembelajaran::where('kelas_id', 'id')->get();
    //     $guru = User::whereIn('role_id', [3, 4])->get();
    //     $mapel = Mapel::all();

    //     return view('admin.result.presensi', compact('kelas', 'thajaran', 'pembelajaran', 'guru', 'mapel'));
    // }

    public function indexrekappresensi($id)
    {
        $pembelajaran = Pembelajaran::with('kelas', 'kelas.jurusan', 'wakel', 'thajaran', 'mapel')->findOrFail($id);

        $siswa = Siswa::where('kelas_id', $pembelajaran->kelas_id)->get();
        $mapel = Mapel::all();
        $thajaran = TahunAjaran::all();
        $kelas = $pembelajaran->kelas;

        return view('admin.result.rekappresensi', compact('pembelajaran', 'mapel', 'thajaran', 'siswa', 'kelas'));
    }

    public function export($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        // Ambil informasi dari kelas
        $kelasTingkat = $kelas->kelas_tingkat; // Pastikan 'kelas_tingkat' adalah kolom yang menyimpan tingkat kelas
        $jurusanId = $kelas->jurusan_id; // Misalkan 'jurusan_id' menyimpan ID jurusan
        $rombel = $kelas->rombel; // Pastikan 'rombel' adalah kolom yang menyimpan rombel

        // Format nama file
        $fileName = 'Nilai Siswa' . ' ' . $kelasTingkat . '-' .  $jurusanId . '-' . $rombel . '.xlsx';

        // Ekspor data
        return Excel::download(new PresensiExport($kelas_id), $fileName);
    }

}