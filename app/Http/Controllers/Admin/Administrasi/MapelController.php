<?php

namespace App\Http\Controllers\Admin\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::all();

        $title = 'Delete Mapel!';
        $text = "Apakah kamu yakin ingin menghapus mapel ini?";
        confirmDelete($title, $text);

        return view('admin.administrasi.mapel', compact('mapel'));
    }

    public function store(Request $request)
    {
        $rules = Mapel::getStoreRules();
        $messages = Mapel::$messages;

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Mapel::create([
            'kode_mapel' => $request->input('kode_mapel'),
            'nama_mapel' => $request->input('nama_mapel'),
        ]);

        return redirect()->route('admin.mapel.index')
            ->with('suksestambah', 'Mapel berhasil ditambahkan')
            ->with('hideAlert', false);
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::findorFail($id);

        $rules = Mapel::getRules($id);
        $messages = Mapel::$messages;

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mapel->kode_mapel = $request->input('kode_mapel');
        $mapel->nama_mapel = $request->input('nama_mapel');
        $mapel->save();

        return redirect()->back()
            ->with('suksesedit', 'Mapel berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($kode_mapel)
    {
        $mapel = Mapel::findOrFail($kode_mapel);

        $relatedPembelajaranCount = Pembelajaran::where('mapel_id', $mapel->id)->count();

        $relatedPresensiCount = Presensi::whereIn('pembelajaran_id', Pembelajaran::where('mapel_id', $mapel->id)->pluck('id'))->count();

        $relatedNilaiCount = Nilai::whereIn('pembelajaran_id', Pembelajaran::where('mapel_id', $mapel->id)->pluck('id'))->count();

        if ($relatedPembelajaranCount > 0 || $relatedPresensiCount > 0 || $relatedNilaiCount > 0) {
           Alert::error("Mapel ini tidak bisa dihapus karena memiliki data yang terkait dengan Pembelajaran.");
           return back();
        }
        Pembelajaran::where('mapel_id' , $mapel->id)->delete();
        $mapel->delete();

        Alert::success("Mapel berhasil dihapus");
        return back();
    }
}
