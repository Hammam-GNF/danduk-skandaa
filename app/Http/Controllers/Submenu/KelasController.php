<?php

namespace App\Http\Controllers\Submenu;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $rombel = Rombel::all();
        return view('submenu.kelas', compact('kelas', 'jurusan', 'rombel'));
    }

    public function store(Request $request)
    {
        $kelas = new Kelas();
        $kelas->kelas_tingkat = $request->input('kelas_tingkat');
        $kelas->jurusan_id = $request->input('jurusan_id');
        $kelas->rombel_id = $request->input('rombel_id');
        $kelas->save();

        return redirect()->route('kelas.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id_kelas)
    {
        $kelas = Kelas::findorFail($id_kelas);
        $kelas->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id_kelas)
    {
        $kelas = Kelas::where('id_kelas', $id_kelas)->first();
        $kelas = Kelas::find($id_kelas);
        $kelas->delete();
        return redirect()->route('kelas.index');
    }

    public function getkelas(Request $request) { //ajax 1 tingkat
        $jurusan_id = $request->jurusan_id;
        $kelas = Kelas::where('jurusan_id', $jurusan_id)->get();

        foreach ($kelas as $item) {
            echo "<option value='$item->id_kelas'>$item->kelas_tingkat</option>";
        }
    }
}