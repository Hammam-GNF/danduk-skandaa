<?php

namespace App\Http\Controllers;

use App\Models\Admin\Jurusan;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TampilanGuruController extends Controller
{
    public function guruDashboard($idMapel = 0, $idTahunAjaran = 0, $idKelas = 0)
    {
        $pembelajaran = Pembelajaran::where('kelas_id', $idKelas)->get();

        $user = Auth::user();
        $guru = Pembelajaran::where('id_guru', $user->id)
        ->with(['guru','mapel', 'kelas.siswa'])
        ->get();
        $kelas = $guru->isNotEmpty() ? $guru->first()->kelas : null;

        $namaKelas = $guru->pluck('kelas.jurusan')->unique();

        $siswa = Siswa::where('kelas_id');

        return view('guru.dashboard', compact('guru', 'namaKelas', 'kelas', 'siswa', 'pembelajaran'));
    }

    public function mengajar($roleId)
    {
        $userId = auth()->id(); 

        if (!in_array($roleId, [3, 4])) {
            abort(403, 'Unauthorized action.');
        }

        $guru = Pembelajaran::where('id_guru', $userId)
        ->with('guru', 'mapel', 'kelas.siswa')
        ->get();

        $mapel = $guru->pluck('mapel')->unique();

        $kelas = $guru->isNotEmpty() ? $guru->first()->kelas : null;

        $wakel = Wakel::where('kelas_id', $userId)->get();

        $mapelWakel = Pembelajaran::where('id_guru', $userId)->get();

        return view('guru.mengajar', compact('mapelWakel', 'mapel', 'wakel', 'guru'));
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

        return view('guru.presensi.kelola', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
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

        return view('guru.nilai.kelola', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }

    public function storepresensi(Request $request)
    {
        $validatedData = $request->validate(Presensi::rules(), Presensi::$messages);

        $attendance = new Presensi($validatedData);
        $attendance->save();

        $id_pembelajaran = $attendance->pembelajaran_id;

        return redirect()->route('guru.presensi.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
            ->with('suksestambah', 'Data presensi berhasil disimpan.');
    }

    public function storenilai(Request $request)
    {
        $validatedData = $request->validate(Nilai::rules(), Nilai::$messages);

        $attendance = new Nilai($validatedData);
        $attendance->save();

        $id_pembelajaran = $attendance->pembelajaran_id;

        return redirect()->route('guru.nilai.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
            ->with('suksestambah', 'Nilai berhasil ditambahkan.');
    }

    public function hasilkelolapresensiguru($id_pembelajaran)
    {
        $userId = auth()->id();
        $guru = Pembelajaran::where('id_guru', $userId)
        ->with('guru', 'mapel', 'kelas.siswa')
        ->get();

        $mapel = $guru->pluck('mapel')->unique();

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

        return view('guru.hasilkelolapresensiguru', compact( 'kelolapresensi','jurusan', 'kelas', 'guru', 'thajaran', 'pembelajaran', 'mapel', 'siswa' ));
    }

    public function hasilkelolanilaiguru($id_pembelajaran)
    {
        $userId = auth()->id();
        $guru = Pembelajaran::where('id_guru', $userId)
        ->with('guru', 'mapel', 'kelas.siswa')
        ->get();

        $mapel = $guru->pluck('mapel')->unique();

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

        return view('guru.hasilkelolanilaiguru', compact( 'kelolanilai','jurusan', 'kelas', 'guru', 'thajaran', 'pembelajaran', 'mapel', 'siswa' ));
    }
}
