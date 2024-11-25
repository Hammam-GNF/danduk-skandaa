<?php

namespace App\Http\Controllers\Wakel\Result;

use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\Wakel;
use Barryvdh\DomPDF\Facade\Pdf;

class TranskripController extends Controller
{
    public function indextranskrip()
    {
        $nilai = Nilai::all();
        $siswa = Siswa::all();
        $mapel = Mapel::all();
        $kelas = Kelas::with(['jurusan', 'wakel', 'mapel', 'thajaran'])->get();
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();
        $jurusan = Jurusan::with(['thajaran'])->get();
        $wakel = Wakel::all();
        $thajaran = TahunAjaran::all();
        $pembelajaran = Pembelajaran::all();

        return view('wakel.result.transkrip', compact('nilai', 'siswa', 'kelas', 'kelas_X', 'kelas_XI', 'kelas_XII', 'mapel', 'thajaran', 'pembelajaran'));
    }

    public function rekaptranskrip($id)
    {
        $pembelajaran = Pembelajaran::with('kelas', 'kelas.jurusan', 'wakel', 'thajaran', 'mapel')->findOrFail($id);

        $siswa = Siswa::where('kelas_id', $pembelajaran->kelas_id)->get();
        $mapel = Mapel::all();
        $thajaran = TahunAjaran::all();
        $presensi = Presensi::whereIn('nis', $siswa->pluck('nis'))->get();

        $kelas = $pembelajaran->kelas; 

        return view('wakel.result.rekaptranskrip', compact('pembelajaran', 'mapel', 'thajaran', 'siswa', 'presensi', 'kelas'));
    }

    public function exportPdf($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $pembelajaran = Pembelajaran::where('kelas_id', $kelas_id)->first(); // Ambil pembelajaran terkait kelas

        $kelasTingkat = $kelas->kelas_tingkat;
        $jurusanId = $kelas->jurusan_id;
        $rombel = $kelas->rombel;

        // Ambil data presensi dan nilai berdasarkan kelas_id dan pembelajaran_id
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $presensi = Presensi::whereIn('nis', $siswa->pluck('nis'))->get();
        $nilai = Nilai::whereIn('nis', $siswa->pluck('nis'))->get();

        $mapel = $pembelajaran ? $pembelajaran->mapel : null; 
        $thajaran = $pembelajaran ? $pembelajaran->thajaran : null;

        // Kirim data ke view
        $data = [
            'kelas' => $kelas,
            'presensi' => $presensi,
            'nilai' => $nilai,
            'siswa' => $siswa,
            'mapel' => $mapel,
            'thajaran' => $thajaran,
            'pembelajaran' => $pembelajaran, 
        ];

        // Load view dan render ke PDF
        $pdf = Pdf::loadView('pdf.transkrip', $data);

        // Format nama file
        $fileName = 'Transkrip_' . $kelasTingkat . '-' . $jurusanId . '-' . $rombel . '.pdf';

        // Return PDF download
        return $pdf->download($fileName);
    }
}
