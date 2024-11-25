<?php

namespace App\Http\Controllers\Admin\Result;

use App\Http\Controllers\Controller;
use App\Models\Admin\Siswa;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\TahunAjaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use App\Models\Admin\Pembelajaran;
use App\Models\Nilai;
use App\Models\User;

class NilaiController extends Controller
{
    public function indexnilai()
    {
        $kelas = Kelas::with('jurusan')->get();
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        if (!$thajaran) {
            $thajaran = (object)[
                'id' => null,
                'thajaran' => 'Tidak ada tahun ajaran aktif',
                'semesterLabel' => ''
            ];
        }
        $pembelajaran = Pembelajaran::where('kelas_id', 'id')->get();
        $guru = User::whereIn('role_id', [3, 4])->get();
        $mapel = Mapel::all();

        return view('admin.result.nilai', compact('kelas', 'thajaran', 'pembelajaran', 'guru', 'mapel'));
    }

    public function indexrekapnilai($id)
    {
        $pembelajaran = Pembelajaran::with('kelas', 'kelas.jurusan', 'wakel', 'thajaran')->findOrFail($id);

        $siswa = Siswa::where('kelas_id', $pembelajaran->kelas_id)->get();
        $nilai = Nilai::where('mapel_id', $pembelajaran->mapel_id)->get();
        $mapel = Mapel::all();
        $thajaran = TahunAjaran::all();
        $kelas = $pembelajaran->kelas;

        return view('admin.result.rekapnilai', compact('pembelajaran', 'mapel', 'thajaran', 'siswa', 'nilai', 'kelas'));
    }

    public function byClass($kelas)
    {
        $kelasData = Kelas::findOrFail($kelas);
        $nilai = Nilai::where('kelas_id', $kelas)->get();
        return view('admin.result.byclass', compact('kelasData', 'nilai'));
    }

    public function export($kelas_id)
    {
        $kelas = Kelas::with('pembelajaran' , 'pembelajaran.mapel')->findOrFail($kelas_id);

        // Ambil informasi dari kelas
        $kelasTingkat = $kelas->kelas_tingkat; // Pastikan 'kelas_tingkat' adalah kolom yang menyimpan tingkat kelas
        $jurusanId = $kelas->jurusan_id; // Misalkan 'jurusan_id' menyimpan ID jurusan
        $rombel = $kelas->rombel; // Pastikan 'rombel' adalah kolom yang menyimpan rombel

        // Format nama file
        $fileName = 'Nilai Siswa' . ' ' . $kelasTingkat . '-' .  $jurusanId . '-' . $rombel . '.xlsx';

        // Ekspor data
        return Excel::download(new NilaiExport($kelas_id), $fileName);
    }

}
