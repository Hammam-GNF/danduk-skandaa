<?php

namespace App\Http\Controllers\Admin\Datamaster;

use App\Http\Controllers\Controller;
use App\Models\Wakel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Mapel;
use App\Models\Admin\Kelas;
use App\Models\Admin\TahunAjaran;
use App\Models\Admin\Jurusan;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PembelajaranController extends Controller
{
    private function getTahunAjaranAktif(){
        return TahunAjaran::where('status','aktif')->first();
    }
    
    public function index()
    {
        $pembelajaran = Pembelajaran::all();
        $mapel = Mapel::all();
        $kelas = Kelas::with('jurusan')->get();
        $guru = User::whereIn('role_id', [3, 4])->get();
        $thajaran = TahunAjaran::where('status', 'aktif')->first();
        if (!$thajaran) {
            $thajaran = (object)[
                'id' => null,
                'thajaran' => 'Tidak ada tahun ajaran aktif',
                'semesterLabel' => ''
            ];
        }

        return view('admin.datamaster.pembelajaran', compact('pembelajaran', 'mapel', 'kelas', 'guru', 'thajaran'));
    }

    public function getMapel($thajaran_id)
    {
        $mapel = Mapel::where('thajaran_id', $thajaran_id)->get();

        return response()->json($mapel);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Pembelajaran::rules(), Pembelajaran::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pembelajaran = new Pembelajaran();
        $pembelajaran->id_guru = $request->input('id_guru');
        $pembelajaran->thajaran_id = $request->input('thajaran_id');
        $pembelajaran->kelas_id = $request->input('kelas_id');
        $pembelajaran->mapel_id = $request->input('mapel_id');
        $pembelajaran->save();

        return redirect()->route('admin.pembelajaran.index')
            ->with('suksestambah', 'Pembelajaran berhasil ditambahkan')
            ->with('hideAlert', false);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Pembelajaran::rules($id), Pembelajaran::$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pembelajaran = Pembelajaran::findOrFail($id);
        $pembelajaran->update([
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'id_guru' => $request->id_guru,
            'thajaran_id' => $request->thajaran_id,
        ]);

        return redirect()->route('admin.pembelajaran.index')
            ->with('suksesedit', 'Pembelajaran berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($id)
    {
        $pembelajaran = Pembelajaran::findOrFail($id);

        // Periksa apakah pembelajaran ditemukan
        if (
            $pembelajaran->presensi()->exists() ||
            $pembelajaran->nilai()->exists()
        ) {
            Alert::error("Data ini tidak bisa dihapus karena memiliki relasi yang terkait.");
            return back();
        }

        $pembelajaran->delete();

        Alert::success("Data Pembelajaran berhasil dihapus");
        return back();
    }
}