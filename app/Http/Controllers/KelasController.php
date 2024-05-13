<?php

namespace App\Http\Controllers;

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
        return view('kelas', compact('kelas', 'jurusan', 'rombel'));
    }

    public function store(Request $request)
    {
        $kelas = new Kelas();
        $kelas->id = $request->input('id');
        $kelas->kelas_tingkat = $request->input('kelas_tingkat');
        $kelas->rombel_id = $request->input('nama_rombel');
        $kelas->jurusan_id = $request->input('jurusan_id');
        $kelas->save();

        return redirect()->route('kelas.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findorFail($id);
        $kelas->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id)
    {
        $kelas = Kelas::where('id_kelas', $id)->first();
        $kelas = Kelas::find($id);
        $kelas->delete();
        return redirect()->route('kelas.index');
    }
}