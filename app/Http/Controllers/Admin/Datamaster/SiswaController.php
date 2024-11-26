<?php

namespace App\Http\Controllers\Admin\Datamaster;

use App\Http\Controllers\Controller;
use App\Models\Admin\Siswa;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Imports\SiswaImport;
use App\Exports\SiswaExport;
use App\Models\Admin\TahunAjaran;
use App\Models\Wakel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class SiswaController extends Controller
{
    private function getTahunAjaranAktif(){
        return TahunAjaran::where('status','aktif')->first();
    }

    public function index(Request $request)
    {
        $tahunAjaranAktif = $this->getTahunAjaranAktif();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('admin.siswa.index')->with('error', 'Pilih tahun ajaran terlebih dahulu untuk menampilkan daftar siswa.');
        }
        $kelas = Kelas::with('jurusan')->get();

        $id = $request->query('id');

        if ($id) {
            $kelas = Kelas::with('jurusan')->findOrFail($id);
            $siswa = Siswa::where('kelas_id', $id)
                ->whereHas('thajaran', function ($query) {
                    $query->where('status', 'aktif');
                })->get();
        } else {
            $siswa = Siswa::whereHas('thajaran', function ($query) {
                $query->where('status', 'aktif');
            })->get();
        }

        $jurusan = Jurusan::all();
        $wakel = Wakel::with('kelas')->get();

        return view('admin.datamaster.siswa', compact('kelas', 'jurusan', 'siswa', 'wakel'));
    }

    public function showSiswaPerKelas($id)
    {
        $kelas = Kelas::with(['jurusan'])->findOrFail($id);
        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        $siswa = Siswa::where('kelas_id', $id)
            ->where('thajaran_id', $tahunAjaranAktif->id)
            ->get();
            
        $jurusan = Jurusan::all();
        
        return view('admin.datamaster.siswaperkelas', compact('kelas', 'siswa', 'jurusan'));
    }

    public function create(Request $request)
    {
        $kelas = Kelas::with('jurusan')->get();
        $tahunAjaranAktif = $this->getTahunAjaranAktif();
        $id = $request->query('id');
        $siswa = Siswa::where('kelas_id', $id)
            ->where('thajaran_id', $tahunAjaranAktif->id)
            ->get();

        $wakel = Wakel::with('kelas')->get();

        return view('admin.form.tambahsiswasemua', compact('kelas', 'wakel'));
    }

    public function getWakel($kelas_id)
    {
        $kelas = Kelas::with('wakel.user', 'jurusan')->find($kelas_id);
        if ($kelas) {
            if ($kelas->wakel) {
                return response()->json(['wakel' => $kelas->wakel]);
            } else {
                return response()->json([
                    'wakel' => null,
                    'jurusan_id' => $kelas->jurusan ? $kelas->jurusan->id : null
                ]);
            }
        }
        
        return response()->json([
            'wakel' => null,
            'jurusan_id' => null
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Siswa::$rules, Siswa::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jns_kelamin' => $request->jns_kelamin,
            'wakel_id' => $request->wakel_id,
            'kelas_id' => $request->kelas_id,
            'status' => $request->status,
            'thajaran_id' => $this->getTahunAjaranAktif()->id,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('suksestambah', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $kelas = Kelas::with('jurusan')->get();

        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        // $kelas = $kelas->where('id', $siswa->kelas_id);
        // $siswa = Siswa::where('kelas_id', $nis);

        return view('admin.form.editsiswasemua', compact('kelas', 'siswa'));
    }

    public function update(Request $request, $nis)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|integer|unique:siswa,nis,' . $nis . ',nis',
            'nama_siswa' => 'required|string|max:255',
            'jns_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $siswa = Siswa::findOrFail($nis);
        $siswa->kelas_id = $request->kelas_id;
        $siswa->nis = $request->nis;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jns_kelamin = $request->jns_kelamin;
        $siswa->status = $request->status;
        $siswa->save();

        $id_kelas = $request->input('kelas_id');

        $jurusan = Jurusan::all();
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();

        return redirect()->route('admin.siswa.index', ['id' => $id_kelas])
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false)
            ->with(compact('jurusan', 'kelas_X', 'kelas_XI', 'kelas_XII'));
    }

    public function destroy($nis)
    {
        try {
            Siswa::where('nis', $nis)->delete();

            $id_kelas = request()->input('id_kelas');
            $jurusan = Jurusan::all();
            $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
            $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
            $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();

            return redirect()->route('admin.siswa.index')
                ->with('sukseshapus', 'Data berhasil dihapus')
                ->with('hideAlert', false)
                ->with(compact('jurusan', 'kelas_X', 'kelas_XI', 'kelas_XII'));
        } catch (\Throwable $th) {
            Alert::error("Data gagal dihapus karena memiliki relasi yang terkait");
            return back();
        }
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:xlsx,xls',
    //         'kelas_id' => 'required|integer|exists:kelas,id'
    //     ]);

    //     $kelasId = $request->input('kelas_id');

    //     try {
    //         Excel::import(new SiswaImport($kelasId), $request->file('file'));

    //         return redirect()->back()->with('suksesimport', 'Import berhasil!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('errorimport', 'Terjadi kesalahan saat import: ' . $e->getMessage());
    //     }
    // }


    public function export()
    {
        return Excel::download(new SiswaExport(), 'Format.xlsx');
    }
}