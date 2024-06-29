<?php

namespace App\Http\Controllers\Submenu;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    public function index($id_kelas)
    {
        $siswa = Siswa::all();
        $kelas_X = Siswa::where('kelas_id', $id_kelas)->get();
        $kelas_XI = Siswa::where('kelas_id', $id_kelas)->get();
        $kelas_XII = Siswa::where('kelas_id', $id_kelas)->get();
        $jurusan = Jurusan::all();
        return view('submenu.siswa', compact('siswa', 'kelas_X', 'kelas_XI', 'kelas_XII', 'jurusan', 'id_kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Kelas::getRules(), Kelas::$messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $siswa = new Siswa;
        $siswa->nis = $request->nis;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jns_kelamin = $request->jns_kelamin;
        $siswa->kelas_tingkat = $request->kelas_tingkat;
        $siswa->jurusan_nama = $request->jurusan_nama;
        $siswa->rombel = $request->rombel;
        $siswa->save();

        return redirect()->route('submenu.siswa.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findorFail($id);
        $siswa->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id)
    {
        $siswa = Siswa::where('nis', $id)->first();
        $siswa = Siswa::find($id);
        $siswa->delete();
        return redirect()->route('submenu.siswa.index');
    }

    // public function import(Request $request, $id_kelas)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|mimes:xls,xlsx'
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('submenu.siswa.index', ['id_kelas' => $id_kelas])
    //             ->with('error', 'Gagal mengimport data. File harus berupa xls atau xlsx.');
    //     }

    //     $file = $request->file('file');

    //     if (!$file->isValid()) {
    //         return redirect()->route('submenu.siswa.index', ['id_kelas' => $id_kelas])
    //             ->with('error', 'Gagal mengimport data. File tidak valid.');
    //     }

    //     SiswaImport::setIdKelas($id_kelas);

    //     Excel::import(new SiswaImport, $file);

    //     return redirect()->route('submenu.siswa.index', ['id_kelas' => $id_kelas])
    //         ->with('suksesimport', 'Data berhasil diimport');
    // }
}