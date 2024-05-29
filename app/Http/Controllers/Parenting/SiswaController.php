<?php

namespace App\Http\Controllers\Parenting;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('parenting.siswa', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama_siswa' => 'required|string|max:255',
        ]);

        $siswa = new Siswa;
        $siswa->nis = $validated['nis'];
        $siswa->nama_siswa = $validated['nama_siswa'];
        $siswa->save();

        return redirect()->route('parenting.siswa.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findorFail($id);
        $siswa->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id)
    {
        $siswa = Siswa::where('nis', $id)->first();
        $siswa = Siswa::find($id);
        $siswa->delete();
        return redirect()->route('parenting.siswa.index');
    }

    public function import(Request $request)
    {
        // $file = $request->file('file');
        // $data = Excel::toArray([], $file);

        // foreach ($data[0] as $row) {
        //     if (isset($row['nis']) && isset($row['nama_siswa'])) {
        //         $validator = Validator::make($row, [
        //             'nis' => 'required|unique:siswa,nis',
        //             'nama_siswa' => 'required|string|max:255',
        //         ]);

        //         if ($validator->fails()) {
        //             continue; // Skip invalid rows
        //         }

        //         Siswa::create([
        //             'nis' => $row['nis'],
        //             'nama_siswa' => $row['nama_siswa'],
        //         ]);
        //     }
        // }

        // return redirect()->route('parenting.siswa.index')
        //     ->with('suksesimport', 'Data berhasil diimport');
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        Excel::import(new SiswaImport, $file);

        return redirect()->route('parenting.siswa.index')
            ->with('suksesimport', 'Data berhasil diimport');
    }
}