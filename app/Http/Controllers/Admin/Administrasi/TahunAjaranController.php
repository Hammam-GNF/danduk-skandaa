<?php

namespace App\Http\Controllers\Admin\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Admin\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $thajaran = TahunAjaran::all();
        return view('admin.administrasi.thajaran', compact('thajaran'));
    }

    public function aktifkanTahunAjaran($idTahunAjaran)
    {
        TahunAjaran::query()->update(['status' => 'nonaktif']);

        TahunAjaran::where('id', $idTahunAjaran)->update(['status' => 'aktif']);
        
        return redirect()->back()->with('message', 'Tahun ajaran Berhasil di aktifkan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), TahunAjaran::rules($request->input('semester')), TahunAjaran::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        TahunAjaran::create([
            'thajaran' => $request->thajaran,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.thajaran.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false);
    }

    public function update(Request $request, $id)
    {
        $thajaran = TahunAjaran::findOrFail($id);

        $validator = Validator::make($request->all(), TahunAjaran::rules($request->input('semester'), $id), TahunAjaran::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $thajaran->thajaran = $request->input('thajaran');
        $thajaran->semester = $request->input('semester');
        $thajaran->save();

        return redirect()->route('admin.thajaran.index')
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($id)
    {
        $thajaran = TahunAjaran::find($id);

        if ($thajaran->siswa()->exists() ||
            $thajaran->pembelajaran()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data ini tidak bisa dihapus karena memiliki relasi yang terkait.'
                ], 400);
            }

        $thajaran->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ], 200);

        return redirect()->route('admin.thajaran.index')->with('sukseshapus', 'Data berhasil dihapus.');
    }
}
