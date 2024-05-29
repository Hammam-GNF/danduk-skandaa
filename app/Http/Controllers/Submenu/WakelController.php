<?php

namespace App\Http\Controllers\Submenu;

use App\Http\Controllers\Controller;
use App\Models\Wakel;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;
use Illuminate\Http\Request;

class WakelController extends Controller
{
    public function index()
    {
        $wakel = Wakel::all();
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();//untuk membuat 2 pilihan yang sama menjadi satu
        // $rombel = Kelas::select('rombel')->distinct()->get();//untuk membuat 2 pilihan yang sama menjadi satu
        $rombel = Rombel::all();
        return view('submenu.wakel', compact('wakel', 'jurusan', 'kelas', 'rombel'));
    }

    public function store(Request $request)
    {
        $wakel = new Wakel;
        $wakel->nip = $request->input('nip');
        $wakel->nama_wakel = $request->input('nama_wakel');
        $wakel->jurusan_id = $request->input('jurusan_id');
        $wakel->kelas_id = $request->input('kelas_id');
        $wakel->rombel_id = $request->input('rombel_id');
        $wakel->save();

        return redirect()->route('wakel.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $nip)
    {
        $wakel = Wakel::findorFail($nip);
        $wakel->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($nip)
    {
        $wakel = Wakel::where('nip', $nip)->first();
        $wakel = Wakel::find($nip);
        $wakel->delete();
        return redirect()->route('wakel.index');
    }
}