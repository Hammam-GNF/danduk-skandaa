<?php

namespace App\Http\Controllers\Admin\Datamaster;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\Wakel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;


class SiswaPerKelasController extends Controller
{
    private function getTahunAjaranAktif(){
        return TahunAjaran::where('status','aktif')->first();
    }

    public function index($id)
    {
        $kelas = Kelas::with(['jurusan'])->findOrFail($id);
        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        $siswa = Siswa::where('kelas_id', $id)
            ->where('thajaran_id', $tahunAjaranAktif->id)
            ->get();
            
        $jurusan = Jurusan::all();
        
        return view('admin.datamaster.siswaperkelas', compact('kelas', 'siswa', 'jurusan'));
    }

    public function create(Request $request, $id)
    {
        $kelas = Kelas::with(['jurusan'])->findOrFail($id); 
        $jurusan = Jurusan::all();

        return view('admin.form.tambahsiswaperkelas', compact('kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Siswa::$rules, Siswa::$messages);

        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $siswa = new Siswa();
        $siswa->nis = $request->input('nis');
        $siswa->nama_siswa = $request->input('nama_siswa');
        $siswa->jns_kelamin = $request->input('jns_kelamin');
        $siswa->kelas_id = $request->input('kelas_id');
        $siswa->status = $request->input('status');

        $siswa->thajaran_id = $tahunAjaranAktif->id;

        $siswa->save();

        return redirect()->route('admin.siswaperkelas.index', ['id' => $request->input('kelas_id')])
        ->with('suksestambah', 'Data berhasil ditambahkan')
        ->with('hideAlert', false);
    }

    public function edit($nis)
    {
        $siswa = Siswa::with(['kelas', 'jurusan'])->where('nis', $nis)->firstOrFail();
        $kelas = Kelas::find($siswa->kelas_id);
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();

        return view('admin.form.editsiswaperkelas', compact('siswa', 'kelas', 'kelas_X', 'kelas_XI', 'kelas_XII'));
    }

    public function update(Request $request, $nis)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|integer',
            'nama_siswa' => 'required|string|max:255',
            'jns_kelamin' => 'required|in:L,P',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $siswa = Siswa::findOrFail($nis);
        $siswa->kelas_id = $request->kelas_id;
        $siswa->nis = $request->nis;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jns_kelamin = $request->jns_kelamin;
        $siswa->status = $request->status;
        $siswa->save();

        return redirect()->route('admin.siswaperkelas.index', ['id' => $siswa->kelas_id])
        ->with('suksesedit', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Request $request, $nis, $kelas)
    {
        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            Alert::error('Data siswa tidak ditemukan');
            return back();
        }

        $presensiExists = Presensi::where('nis', $nis)->exists();
        $nilaiExists = Nilai::where('nis', $nis)->exists();

        if ($presensiExists || $nilaiExists) {
            Alert::error('Data gagal dihapus karena memiliki relasi yang terkait');
            return back();
        }

        $siswa->delete();

        // Ambil data yang diperlukan
        $jurusan = Jurusan::all();
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();

        // Redirect ke route yang sesuai dengan kelas_id
        return redirect()->route('admin.siswaperkelas.index', ['id' => $kelas])
            ->with('sukseshapus', 'Data berhasil dihapus')
            ->with('hideAlert', false)
            ->with(compact('jurusan', 'kelas_X', 'kelas_XI', 'kelas_XII'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'kelas_id' => 'required|integer|exists:kelas,id'
        ]);

        $kelasId = $request->input('kelas_id');
        $thajaranId = $this->getTahunAjaranAktif()->id;

        try {
            Excel::import(new SiswaImport($kelasId, $thajaranId), $request->file('file'));

            return redirect()->back()->with('suksesimport', 'Import berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errorimport', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
