<?php

namespace App\Http\Controllers;

use App\Models\Wakel;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class WakelController extends Controller
{
    public function index()
    {
        $wakel = Wakel::all();
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();//untuk membuat 2 pilihan yang sama menjadi satu
        // $rombel = Kelas::select('rombel')->distinct()->get();//untuk membuat 2 pilihan yang sama menjadi satu
        return view('wakel', compact('wakel', 'jurusan', 'kelas'));
    }

    public function store(Request $request)
    {
        $wakel = new Wakel;
        $wakel->nip = $request->input('nip');
        $wakel->nama_wakel = $request->input('nama_wakel');
        $wakel->jurusan_id = $request->input('jurusan_id');
        $wakel->kelas_id = $request->input('rombel');
        $wakel->save();

        return redirect()->route('wakel.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id)
    {
        $wakel = Wakel::findorFail($id);
        $wakel->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id)
    {
        $wakel = Wakel::where('nip', $id)->first();
        $wakel = Wakel::find($id);
        $wakel->delete();
        return redirect()->route('wakel.index');
    }
}