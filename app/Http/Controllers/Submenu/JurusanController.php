<?php

namespace App\Http\Controllers\Submenu;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('submenu.jurusan', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $jurusan = new Jurusan;
        $jurusan->id_jurusan = $request->input('id_jurusan');
        $jurusan->nama_jurusan = $request->input('nama_jurusan');
        $jurusan->save();   

        return redirect()->route('jurusan.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id_jurusan)
    {
        $jurusan = Jurusan::findorFail($id_jurusan);
        $jurusan->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id_jurusan)
    {
        $jurusan = Jurusan::where('id_jurusan', $id_jurusan)->first();
        $jurusan = Jurusan::find($id_jurusan);
        $jurusan->delete();
        return redirect()->route('jurusan.index');
    }
}