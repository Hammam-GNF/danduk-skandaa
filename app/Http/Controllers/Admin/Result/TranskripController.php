<?php

namespace App\Http\Controllers\Admin\Result;

use App\Exports\AdminPresensiExport;
use App\Exports\TranskripExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Wakel;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class TranskripController extends Controller
{
    public function indextranskrip()
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
        $pembelajaran = Pembelajaran::all();
        $guru = User::whereIn('role_id', [3, 4])->get();
        $mapel = Mapel::all();

        return view('admin.result.transkrip', compact('kelas'));
    }

    public function rekaptranskrip($id)
    {
        $kelas = Kelas::with('pembelajaran', 'jurusan', 'wakel', 'thajaran', 'pembelajaran.mapel', 'siswa')->findOrFail($id);
        $pembelajaran = Pembelajaran::with('kelas', 'kelas.jurusan', 'wakel', 'thajaran', 'mapel')->findOrFail($id);

        $siswa = $kelas->siswa()->paginate(10);

        $mapel = Mapel::all();
        $thajaran = TahunAjaran::all();
        $presensi = Presensi::all();


        return view('admin.result.rekaptranskrip', compact('pembelajaran', 'mapel', 'thajaran', 'siswa', 'presensi', 'kelas'));
    }


    public function exportNilaiAllPdf($kelas_id)
    {
        $kelas = Kelas::with(['pembelajaran.mapel', 'jurusan', 'presensi', 'pembelajaran' => function ($query) {
            $query->with('mapel');
        }])->findOrFail($kelas_id);

        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $nilai = Nilai::whereIn('nis', $siswa->pluck('nis'))->get();

        // $kelas = Kelas::with('pembelajaran.mapel', 'pembelajaran.nilai', 'jurusan')->findOrFail($kelas_id);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $wakel = Wakel::where('kelas_id', $kelas_id)->first();

        $guruPengampu = Pembelajaran::where('id_guru', $kelas_id)->first();

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        $data = [
            'kelas' => $kelas,
            'presensi' => $kelas->presensi,
            'siswa' => $siswa,
            'wakel' => $wakel,
            'guruPengampu' => $guruPengampu,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ];

        $pdf = Pdf::loadView('pdf.nilai', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '-' . $kelas->rombel . '.pdf';

        return $pdf->stream($fileName);
    }


    public function presensiAllPdf($kelas_id)
    {
        $kelas = Kelas::with(['pembelajaran.mapel', 'jurusan', 'presensi', 'pembelajaran' => function ($query) {
            $query->with('mapel');
        }])->findOrFail($kelas_id);

        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $wakel = Wakel::where('kelas_id', $kelas_id)->first();

        $mapelIds = $kelas->pembelajaran->pluck('mapel_id')->toArray();

        $guruPengampu = Pembelajaran::whereIn('mapel_id', $mapelIds)->pluck('id_guru');

        $guruData = User::whereIn('id', $guruPengampu)->get();

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        $data = [
            'kelas' => $kelas,
            'presensi' => $kelas->presensi,
            'siswa' => $siswa,
            'wakel' => $wakel,
            'guruPengampu' => $guruData,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ];

        $pdf = Pdf::loadView('pdf.presensi', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '-' . $kelas->rombel . '.pdf';
        return $pdf->stream($fileName);
    }

    public function presensiAllExcel($kelas_id) {
        $kelas = Kelas::with(['pembelajaran.mapel', 'jurusan', 'presensi', 'pembelajaran' => function ($query) {
            $query->with('mapel');
        }])->findOrFail($kelas_id);

        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $wakel = Wakel::find($kelas->wakel_id);
        $thajaran = TahunAjaran::find($kelas->thajaran_id);

        return Excel::download(new AdminPresensiExport($kelas, $wakel, $thajaran, $siswa), 'Presensi_' . $kelas->kelas_tingkat . '.xlsx');
    }
    public function exportNilaiAllExcel($kelas_id)
    {
        $kelas = Kelas::with('pembelajaran.mapel', 'pembelajaran.nilai', 'jurusan')->findOrFail($kelas_id);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '.xlsx';

        return Excel::download(new TranskripExport($kelas, $siswa), $fileName);
    }


    public function exportPdf($kelas_id)
    {
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $presensi = Presensi::whereIn('nis', $siswa->pluck('nis'))->get();

        $kelas = Kelas::with('pembelajaran.mapel', 'pembelajaran.nilai', 'jurusan')->findOrFail($kelas_id);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $wakel = Wakel::find($kelas->wakel_id);
        $thajaran = TahunAjaran::find($kelas->thajaran_id);

        $data = [
            'kelas' => $kelas,
            'presensi' => $presensi,
            'siswa' => $siswa,
            'wakel' => $wakel,
            'thajaran' => $thajaran,

        ];
        $pdf = Pdf::loadView('pdf.transkrip', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '.pdf';

        return $pdf->download($fileName);
    }


    public function exportPdfSiswa($nis)
    {
        $siswa = Siswa::with(['thajaran', 'wakel', 'jurusan', 'kelas', 'presensi', 'nilai', 'kelas.jurusan'])
            ->findOrFail($nis);
        $data = [
            'siswa' => $siswa,
            'kelas' => $siswa->kelas,
            'thajaran' => $siswa->thajaran,
            'wakel' => $siswa->wakel
        ];

        $pdf = Pdf::loadView('pdf.trsiswa', $data);

        $fileName = 'Transkrip_' . $siswa->nama_siswa . '-' . $siswa->kelas->jurusan->kode_jurusan . '.pdf';

        return $pdf->download($fileName);
    }

    public function indextranskripPresensi()
    {
        $kelas = TahunAjaran::with('kelas', 'kelas.pembelajaran', 'kelas.wakel', 'kelas.thajaran', 'kelas.jurusan')->get();

        return view('admin.result.presensi', compact('kelas'));
    }


    public function rekaptranskripPresensi($id)
    {
        $kelas = Kelas::with('jurusan')->findOrFail($id);
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        if (!$thajaran) {
            $thajaran = (object)[
                'id' => null,
                'thajaran' => 'Tidak ada tahun ajaran aktif',
                'semesterLabel' => ''
            ];
        }
        $pembelajaran = Pembelajaran::where('kelas_id', $kelas->id)->first();
        if (!$pembelajaran) {
            $pembelajaran = (object)[
                'kelas' => $kelas,
                'mapel' => (object)[
                    'nama_mapel' => 'Tidak ada mata pelajaran'
                ]
            ];
        }
        $guru = User::whereIn('role_id', [3, 4])->get();
        $siswa = Siswa::all();
        $mapel = Mapel::all();
        $presensi = Presensi::all();

        return view('admin.result.rekappresensi', compact('pembelajaran', 'mapel', 'thajaran', 'siswa', 'presensi', 'kelas'));
    }


    public function exportPdfPresensi($kelas_id)
    {
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $presensi = Presensi::whereIn('nis', $siswa->pluck('nis'))->get();

        $kelas = Kelas::with('pembelajaran.mapel', 'pembelajaran.nilai', 'jurusan')->findOrFail($kelas_id);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $wakel = Wakel::find($kelas->wakel_id);
        $thajaran = TahunAjaran::find($kelas->thajaran_id);

        $data = [
            'kelas' => $kelas,
            'presensi' => $presensi,
            'siswa' => $siswa,
            'wakel' => $wakel,
            'thajaran' => $thajaran,

        ];

        $pdf = Pdf::loadView('pdf.transkrip', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '.pdf';

        return $pdf->download($fileName);
    }
}
