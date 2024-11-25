<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TampilanWakelController extends Controller
{
    public function wakelDashboard($idMapel = 0, $idTahunAjaran = 0, $idKelas = 0)
    {
        $pembelajaran = Pembelajaran::where('kelas_id', $idKelas)->get();

        $user = Auth::user();
        $wakels = Wakel::where('user_id', $user->id)
        ->with('kelas.siswa')
        ->get();
        $kelas = $wakels->isNotEmpty() ? $wakels->first()->kelas : null;

        $jumlahSiswa = $wakels->reduce(function ($carry, $wakel) {
            return $carry + $wakel->kelas->siswa->count();
        }, 0);

        $siswa = Siswa::where('kelas_id');

        return view('wakel.dashboard', compact('wakels', 'jumlahSiswa', 'kelas', 'siswa', 'pembelajaran'));
    }

    public function mengajar($roleId)
    {
        $userId = auth()->id(); 

        if (!in_array($roleId, [3, 4])) {
            abort(403, 'Unauthorized action.');
        }

        $wakels = Wakel::where('user_id', $userId)
        ->with('kelas.siswa')
        ->get();
        $kelas = $wakels->isNotEmpty() ? $wakels->first()->kelas : null;

        $wakel = Wakel::where('kelas_id', $userId)->get();

        $mapelWakel = Pembelajaran::where('id_guru', $userId)->get();

        return view('wakel.mengajar', compact('mapelWakel', 'wakel', 'wakels'));
    }

    private function getTahunAjaranAktif()
    {
        return TahunAjaran::where('status', 'aktif')->first();
    }

    public function kelolapresensi($id)
    {
        $userId = auth()->user()->id;

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'kelas.wakel', 'mapel', 'guru'])
        ->where('id_guru', $userId)
        ->findOrFail($id);

        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        $kelas = $pembelajaran->kelas;
        $wakel = $kelas->wakel;
        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->where('thajaran_id', $tahunAjaranAktif->id)
            ->get();

        return view('wakel.presensi.kelola', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }

    public function kelolanilai($id)
    {
        $userId = auth()->user()->id;

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'kelas.wakel', 'mapel', 'guru'])
        ->where('id_guru', $userId)
        ->findOrFail($id);

        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        $kelas = $pembelajaran->kelas;
        $wakel = $kelas->wakel;
        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->where('thajaran_id', $tahunAjaranAktif->id)
            ->get();

        return view('wakel.nilai.kelola', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }

    //CRUD PRESENSI
    public function storepresensi(Request $request)
    {
        $validatedData = $request->validate(Presensi::rules(), Presensi::$messages);

        $attendance = new Presensi($validatedData);
        $attendance->save();

        $id_pembelajaran = $attendance->pembelajaran_id;

        return redirect()->route('wakel.presensi.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
            ->with('suksestambah', 'Data presensi berhasil disimpan.');
    }

    public function storenilai(Request $request)
    {
        $validatedData = $request->validate(Nilai::rules(), Nilai::$messages);

        $attendance = new Nilai($validatedData);
        $attendance->save();

        $id_pembelajaran = $attendance->pembelajaran_id;

        return redirect()->route('wakel.nilai.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
            ->with('suksestambah', 'Nilai berhasil ditambahkan.');
    }

    public function hasilkelolapresensiwakel($id_pembelajaran)
    {
        $userId = auth()->id();
        $wakels = Wakel::where('user_id', $userId)
            ->with('kelas.siswa')
            ->get();
            $kelas = $wakels->isNotEmpty() ? $wakels->first()->kelas : null;

        $kelolapresensi = Presensi::where('pembelajaran_id', $id_pembelajaran)
            ->with(['siswa', 'kelas', 'jurusan', 'thajaran', 'mapel'])
            ->get()
            ->groupBy('mapel.kode_mapel');

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'mapel'])->findOrFail($id_pembelajaran);

        $jurusan = Jurusan::all();
        $thajaran = TahunAjaran::all();

        $kelas = $pembelajaran->kelas;
        
        $mapel = Mapel::all();
        $siswa = Siswa::with(['kelas.jurusan'])->where('kelas_id', $kelas->id)->get();

        return view('wakel.hasilkelolapresensiwakel', compact( 'kelolapresensi','jurusan', 'kelas', 'wakels', 'thajaran', 'pembelajaran', 'mapel', 'siswa' ));
    }

    public function hasilkelolanilaiwakel($id_pembelajaran)
    {
        $userId = auth()->id();
        $wakels = Wakel::where('user_id', $userId)
            ->with('kelas.siswa')
            ->get();
            $kelas = $wakels->isNotEmpty() ? $wakels->first()->kelas : null;

        $kelolanilai = Nilai::where('pembelajaran_id', $id_pembelajaran)
            ->with(['siswa', 'kelas', 'jurusan', 'thajaran', 'mapel'])
            ->get()
            ->groupBy('mapel.kode_mapel');

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'mapel'])->findOrFail($id_pembelajaran);

        $jurusan = Jurusan::all();
        $thajaran = TahunAjaran::all();
        $kelas = $pembelajaran->kelas;
        $mapel = Mapel::all();
        $siswa = Siswa::with(['kelas.jurusan'])->where('kelas_id', $kelas->id)->get();

        return view('wakel.hasilkelolanilaiwakel', compact( 'kelolanilai','jurusan', 'kelas', 'wakels', 'thajaran', 'pembelajaran', 'mapel', 'siswa' ));
    }

    // =================================================================================================



    // TAMPILAN MENGAJAR SEBAGAI WAKEL
    public function hasilkelolapresensi($roleId)
    {
        $userId = auth()->id(); 

        if (!in_array($roleId, [3, 4])) {
            abort(403, 'Unauthorized action.');
        }

        $wakels = Wakel::where('user_id', $userId)
        ->with('kelas.siswa')
        ->get();

        $kelasIds = $wakels->pluck('kelas_id')->unique();
        // dd($kelasIds);

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'mapel'])
        ->whereHas('kelas.wakel', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

        $presensi = Presensi::whereIn('kelas_id', $kelasIds)
        ->whereIn('pembelajaran_id', $pembelajaran->pluck('id'))
        ->with(['siswa', 'mapel'])
        ->get();

        $kelolapresensi = $presensi->groupBy('siswa.nis')->map(function ($group) {
            return $group->keyBy('mapel.kode_mapel');
        });

        return view('wakel.presensi.hasilkelola', compact('kelolapresensi', 'pembelajaran', 'wakels', 'userId', 'kelasIds'));
    }

    public function hasilkelolanilai($roleId)
    {
        $userId = auth()->id(); 

        if (!in_array($roleId, [3, 4])) {
            abort(403, 'Unauthorized action.');
        }

        $wakels = Wakel::where('user_id', $userId)
        ->with('kelas.siswa')
        ->get();
        $kelasIds = $wakels->pluck('kelas_id')->unique();

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'mapel'])
        ->whereHas('kelas.wakel', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

        $nilai = Nilai::whereIn('kelas_id', $kelasIds)
        ->whereIn('pembelajaran_id', $pembelajaran->pluck('id'))
        ->with(['siswa', 'mapel'])
        ->get();

        $kelolanilai = $nilai->groupBy('siswa.nis')->map(function ($group) {
            return $group->keyBy('mapel.kode_mapel');
        });

        return view('wakel.nilai.hasilkelola', compact('kelolanilai', 'pembelajaran', 'wakels'));
    }

    // =================================================================================================

    //export
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

        $pdf = Pdf::loadView('wakel.pdf.presensi', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '-' . $kelas->rombel . '.pdf';
        return $pdf->stream($fileName);
    }

    public function nilaiAllPdf($kelas_id)
    {
        $userId = auth()->id(); 

        $kelas = Kelas::with(['pembelajaran.mapel', 'jurusan', 'nilai', 'pembelajaran' => function ($query) {
            $query->with('mapel');
        }])->findOrFail($kelas_id);

        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        // $wakel = Wakel::where('kelas_id', $kelas_id)->first();

        $wakel = Wakel::where('user_id', $userId)->where('kelas_id', $kelas_id)->first();

        $guruPengampu = Pembelajaran::where('id_guru', $kelas_id)->first();

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        $data = [
            'kelas' => $kelas,
            'nilai' => $kelas->nilai,
            'siswa' => $siswa,
            'wakel' => $wakel,
            'guruPengampu' => $guruPengampu,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ];

        $pdf = Pdf::loadView('wakel.pdf.nilai', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '-' . $kelas->rombel . '.pdf';
        return $pdf->stream($fileName);
    }

    public function exportPdfSiswa($nis)
    {
        $userId = auth()->id();

        $siswa = Siswa::with(['thajaran', 'wakel.user', 'presensi', 'nilai', 'kelas.jurusan'])
            ->findOrFail($nis);
        
        $wakel = Wakel::with('user')->where('user_id', $userId)->first();


        $data = [
            'siswa' => $siswa,
            'kelas' => $siswa->kelas,
            'thajaran' => $siswa->thajaran,
            'wakel' => $wakel,
        ];

        $pdf = Pdf::loadView('pdf.trsiswa', $data);

        $fileName = 'Transkrip_' . $siswa->nama_siswa . '-' . $siswa->kelas->jurusan->kode_jurusan . '.pdf';

        return $pdf->stream($fileName);
    }

}
