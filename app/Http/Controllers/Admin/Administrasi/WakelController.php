<?php

namespace App\Http\Controllers\Admin\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\TahunAjaran;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class WakelController extends Controller
{
    public function index()
    {
        $guru = User::where('role_id', '4')->get();
        $user = User::where('role_id', '!=', 1)->get();
        $wakel = Wakel::with('user', 'kelas.jurusan')->get();
        $kelas = Kelas::with('jurusan')->get();

        return view('admin.administrasi.wakel', compact('user', 'guru', 'wakel', 'kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Wakel::getStoreRules(), Wakel::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Wakel::create([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
        ]);
        
        User::where('id', $request->user_id)->update(['role_id' => '3']);

        return redirect()->route('admin.wakel.index')
        ->with('suksestambah', 'Data berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $wakel = Wakel::findOrFail($id);

        $rules = Wakel::getUpdateRules($id);
        $messages = Wakel::$messages;

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $wakel->update($request->all());

        return redirect()->route('admin.wakel.index')
            ->with('suksesedit', 'Kelas berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($id)
    {
        $wakel = Wakel::findOrFail($id);

        $relatedPembelajaranCount = Pembelajaran::where('wakel_id', $id)->count();

        $relatedPresensiCount = Presensi::whereIn('pembelajaran_id', Pembelajaran::where('wakel_id', $id)->pluck('id'))->count();

        $relatedNilaiCount = Nilai::whereIn('pembelajaran_id', Pembelajaran::where('wakel_id', $id)->pluck('id'))->count();

        if ($relatedPembelajaranCount > 0 || $relatedPresensiCount > 0 || $relatedNilaiCount > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data ini tidak bisa dihapus karena memiliki relasi yang terkait.'
            ], 400);
        }

        $wakel->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ], 200);
    }

    public function checkRelatedData($wakel_id)
    {
        $countRelatedData = Kelas::where('wakel_id', $wakel_id)->count();

        if ($countRelatedData > 0) {
            return response()->json([
                'hasRelatedData' => true,
                'countRelatedData' => $countRelatedData,
                'relatedEntityType' => 'kelas'
            ]);
        }

        return response()->json(['hasRelatedData' => false]);
    }
}
