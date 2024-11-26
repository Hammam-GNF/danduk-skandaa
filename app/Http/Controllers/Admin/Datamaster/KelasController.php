<?php

namespace App\Http\Controllers\Admin\Datamaster;

use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\TahunAjaran;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();

        return view('admin.datamaster.kelas', compact('kelas', 'jurusan'));
    }

    public function getJurusanByThajaran($thajaran_id)
    {
        $jurusan = Jurusan::where('thajaran_id', $thajaran_id)->get();

        return response()->json(['jurusan' => $jurusan]);
    }
    public function getWakelByThajaran($thajaran_id)
    {
        $wakel = Wakel::where('thajaran_id', $thajaran_id)->get();

        return response()->json(['wakel' => $wakel]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Kelas::storeRules(), Kelas::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kelas = Kelas::create($request->all());

        if ($kelas) {
            return redirect()->back()
                ->with('suksestambah', 'Kelas berhasil ditambahkan')
                ->with('hideAlert', false)
                ->with('new_kelas', $kelas);
        } else {
            return redirect()->back()
                ->with('gagal', 'Kelas tingkat tidak valid')
                ->with('hideAlert', false);
        }
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $rules = Kelas::getRules($id);
        $messages = Kelas::$messages;

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')
            ->with('suksesedit', 'Kelas berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        if ($kelas->siswa()->exists() || 
            $kelas->pembelajaran()->exists()) {
            Alert::error("Data ini tidak bisa dihapus karena memiliki data yang terkait.");
            return back();
        }

        $kelas->delete();

        Alert::success("Kelas berhasil dihapus");
        return back();

    }


    public function checkRelatedData($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);

            $hasRelatedSiswa = $kelas->siswa()->exists();
            $hasRelatedPembelajaran = $kelas->pembelajaran()->exists();
            $hasRelatedKelolaPresensi = $kelas->kelolapresensi()->exists();

            $response = [
                'hasRelatedSiswa' => $hasRelatedSiswa,
                'hasRelatedPembelajaran' => $hasRelatedPembelajaran,
                'hasRelatedKelolaPresensi' => $hasRelatedKelolaPresensi,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function getTargetIdByKelasTingkat($kelas_tingkat)
    {
        switch ($kelas_tingkat) {
            case 'X':
                return 'collapseExample';
            case 'XI':
                return 'collapseExample2';
            case 'XII':
                return 'collapseExample3';
            default:
                return null;
        }
    }
}
