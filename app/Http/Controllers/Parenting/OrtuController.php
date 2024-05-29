<?php

namespace App\Http\Controllers\Parenting;

use App\Http\Controllers\Controller;
use App\Models\Ortu;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    public function index()
    {
        $ortu = Ortu::all();
        return view('parenting.ortu', compact('ortu'));
    }

    public function store(Request $request)
    {
        $ortu = new Ortu;
        $ortu->no_hp = $request->input('no_hp');
        $ortu->nama_ayah = $request->input('nama_ayah');
        $ortu->save();

        return redirect()->route('parenting.ortu.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id)
    {
        $ortu = Ortu::findorFail($id);
        $ortu->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id)
    {
        $ortu = Ortu::where('no_hp', $id)->first();
        $ortu = Ortu::find($id);
        $ortu->delete();
        return redirect()->route('parenting.ortu.index');
    }
}