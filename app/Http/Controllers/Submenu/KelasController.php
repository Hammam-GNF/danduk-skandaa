<?php

namespace App\Http\Controllers\Submenu;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();
        $jurusan = Jurusan::all();
        return view('submenu.kelas', compact('kelas_X', 'kelas_XI', 'kelas_XII', 'jurusan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Kelas::getRules(), Kelas::$messages);
        if ($validator->fails()) {
            return redirect() -> back()
                ->withErrors($validator)
                ->withInput();
        }

        $kelas = new Kelas();
        $kelas->id_kelas = $request->id_kelas;
        $kelas->kelas_tingkat = $request->kelas_tingkat;
        $kelas->jurusan_id = $request->jurusan_id;
        $kelas->rombel = $request->rombel;
        $kelas->save();

        $target_id = match($kelas->kelas_tingkat) {
            'X' => 'tambahkelasX',
            'XI' => 'tambahkelasXI',
            'XII' => 'tambahkelasXII',
            default => null,
        };
    
        if ($target_id) {
            return redirect()->back()
                ->with('suksestambah', 'Data berhasil ditambahkan')
                ->with('hideAlert', false)
                ->with('new_kelas', $kelas)
                ->with('target_id', $target_id);
        } else {
            return redirect()->back()
                ->with('gagal', 'Kelas tingkat tidak valid')
                ->with('hideAlert', false);
        }
    }


    public function update(Request $request, $id_kelas)
    {
        $validated = $request->validate([
            'id_kelas' => 'required|string|max:255',
            'kelas_tingkat' => 'required|string|max:5',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id_kelas);
        $kelas->update($validated);

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        $kelas->delete();
        return redirect()->route('kelas.index')
            ->with('sukseshapus', 'Data berhasil dihapus')
            ->with('hideAlert', false);
    }

    public function getkelas(Request $request)
    {
        $jurusan_id = $request->jurusan_id;
        $kelas = Kelas::where('jurusan_id', $jurusan_id)->get();

        foreach ($kelas as $item) {
            echo "<option value='{$item->id_kelas}'>{$item->kelas_tingkat} - {$item->jurusan_id} - {$item->rombel}</option>";
        }
    }
}