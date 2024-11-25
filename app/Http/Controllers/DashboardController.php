<?php

namespace App\Http\Controllers;

use App\Models\Admin\Jurusan;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\User;
use App\Models\Wakel;

class DashboardController extends Controller
{

    private function getTahunAjaranAktif(){
        return TahunAjaran::where('status','aktif')->first();
    }

    public function adminDashboard()
    {
        $tahunAjaranAktif = $this->getTahunAjaranAktif();
        $jumlahPengguna = User::where('role_id', '!=', 1)->count();
        $jumlahJurusan = Jurusan::count();
        $jumlahMapel = Mapel::count();
        $jumlahKelas = Kelas::count();
        $jumlahSiswa = Siswa::count();

        return view('admin.dashboard', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'jumlahPengguna' => $jumlahPengguna,
            'jumlahJurusan' => $jumlahJurusan,
            'jumlahMapel' => $jumlahMapel,
            'jumlahKelas' => $jumlahKelas,
            'jumlahSiswa' => $jumlahSiswa,
        ]);
    }

    public function wakelDashboard()
    {
        $user = Auth::user();
        $wakels = Wakel::where('user_id', $user->id)
        ->with('kelas.siswa')
        ->get();
        $kelas = $wakels->isNotEmpty() ? $wakels->first()->kelas : null;

        $jumlahSiswa = $wakels->reduce(function ($carry, $wakel) {
            return $carry + $wakel->kelas->siswa->count();
        }, 0);

        $siswa = Siswa::where('kelas_id');

        return view('wakel.dashboard', compact('wakels', 'jumlahSiswa', 'kelas', 'siswa'));
    }

    public function guruDashboard()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Pengguna tidak ditemukan. Silakan login.');
        }
    
        if ($user->role_id != 4) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    
        // $guruCollection = $user->guru;
    
        // if ($guruCollection->isEmpty()) {
        //     return redirect()->route('login')->with('error', 'Data wali kelas tidak ditemukan.');
        // }
    
        // $jumlahSiswa = $guruCollection->sum(function ($wakel) {
        //     return $wakel->kelas->sum(function ($kelas) {
        //         return $kelas->siswa->count();
        //     });
        // });
    
        return view('guru.dashboard');
    }
    
}
