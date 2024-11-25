<?php

namespace App\Http\Controllers\Admin\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('admin.administrasi.jurusan', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $rules = Jurusan::getStoreRules();
        $messages = Jurusan::$messages;

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Jurusan::create([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('admin.jurusan.index')
            ->with('suksestambah', 'Jurusan berhasil ditambahkan')
            ->with('hideAlert', false);
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $rules = Jurusan::getRules($id); 
        $messages = Jurusan::$messages;

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jurusan->kode_jurusan = $request->input('kode_jurusan');
        $jurusan->nama_jurusan = $request->input('nama_jurusan');
        $jurusan->save();

        return redirect()->route('admin.jurusan.index')
            ->with('suksesedit', 'Jurusan berhasil diperbarui')
            ->with('hideAlert', false);
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        if ($jurusan->kelas()->exists() ||
            $jurusan->siswa()->exists() ||
            $jurusan->pembelajaran()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data ini tidak bisa dihapus karena memiliki relasi yang terkait.'
                ], 400);
            }

        $jurusan->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ], 200);

        return redirect()->route('admin.jurusan.index')->with('sukseshapus', 'Data berhasil dihapus.');
    }

}