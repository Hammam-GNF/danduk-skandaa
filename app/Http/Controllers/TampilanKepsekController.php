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
use App\Models\Role;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Http\Request;

class TampilanKepsekController extends Controller
{
    private function getTahunAjaranAktif(){
        return TahunAjaran::where('status','aktif')->first();
    }

    public function kepsekDashboard()
    {
        $tahunAjaranAktif = $this->getTahunAjaranAktif();
        $jumlahPengguna = User::where('role_id', '!=', 1)->count();
        $jumlahJurusan = Jurusan::count();
        $jumlahMapel = Mapel::count();
        $jumlahKelas = Kelas::count();
        $jumlahSiswa = Siswa::count();

        return view('kepsek.dashboard', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'jumlahPengguna' => $jumlahPengguna,
            'jumlahJurusan' => $jumlahJurusan,
            'jumlahMapel' => $jumlahMapel,
            'jumlahKelas' => $jumlahKelas,
            'jumlahSiswa' => $jumlahSiswa,
        ]);
    }

    public function pengguna()
    {
        $users = User::all();
        $roles = Role::where('id', '!=', 3)->get();
        return view('kepsek.administrasi.pengguna', compact('users','roles'));
    }

    public function thajaran()
    {
        $thajaran = TahunAjaran::all();
        return view('kepsek.administrasi.thajaran', compact('thajaran'));
    }

    public function jurusan()
    {
        $jurusan = Jurusan::all();
        return view('kepsek.administrasi.jurusan', compact('jurusan'));
    }

    public function mapel()
    {
        $mapel = Mapel::all();
        return view('kepsek.administrasi.mapel', compact('mapel'));
    }

    public function kelas()
    {
        $kelas = Kelas::all();
        return view('kepsek.datamaster.kelas', compact('kelas'));
    }

    public function wakel()
    {
        $wakel = Wakel::all();
        return view('kepsek.datamaster.wakel', compact('wakel'));
    }

    public function siswa()
    {
        $siswa = Siswa::all();
        return view('kepsek.datamaster.siswa', compact('siswa'));
    }

    public function pembelajaran()
    {
        $pembelajaran = Pembelajaran::all();
        return view('kepsek.datamaster.pembelajaran', compact('pembelajaran'));
    }

    public function result()
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

        return view('kepsek.result.daftarkelas', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }

    public function rekapPresensi($id)
    {
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        $presensi = Presensi::where('kelas_id', $id)->get();

        $presensiPertama = $presensi->first();

        $kelas = $presensiPertama ? $presensiPertama->kelas : null;
        
        return view('kepsek.result.rekappresensi', compact('thajaran', 'presensi', 'kelas'));
    }

    public function rekapNilai($id)
    {
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        $nilai = Nilai::where('kelas_id', $id)->get();

        $nilaiPertama = $nilai->first();

        $kelas = $nilaiPertama ? $nilaiPertama->kelas : null;
        
        return view('kepsek.result.rekapnilai', compact('thajaran', 'nilai', 'kelas'));
    }
}
