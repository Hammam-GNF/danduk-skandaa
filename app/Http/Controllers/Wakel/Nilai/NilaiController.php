<?php

namespace App\Http\Controllers\Wakel\Nilai;

use App\Http\Controllers\Controller;
use App\Models\Admin\Siswa;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\TahunAjaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Pembelajaran;
use App\Models\Wakel;
use App\Models\Nilai;
use App\Models\Presensi;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    public function indexwakel($id)
    {
        $kelas = Kelas::with('jurusan')->findOrFail($id);

        // Ambil data pembelajaran berdasarkan kelas
        $pembelajaran = Pembelajaran::where('kelas_id', $kelas->id) // Menyesuaikan dengan primary key id
            ->with(['kelas.jurusan'])
            ->get();

        return view('wakel.nilai.nilai', compact('kelas', 'pembelajaran'));
    }

    public function kelola($id)
    {
        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'kelas.wakel'])->findOrFail($id);
        $wakel = $pembelajaran->kelas->wakel;
        $kelas = $pembelajaran->kelas;
        $thajaran = TahunAjaran::all();

        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->where('jurusan_id', $kelas->jurusan_id)
            ->get();

        $mapel = Mapel::all();

        return view('wakel.nilai.kelola', compact('kelas', 'thajaran', 'siswa', 'pembelajaran', 'wakel', 'mapel'));
    }

    public function hasilkelola($id_pembelajaran)
    {
        $kelolanilai = Nilai::where('pembelajaran_id', $id_pembelajaran)
            ->with(['siswa', 'kelas', 'jurusan', 'thajaran'])
            ->get();

        $pembelajaran = Pembelajaran::with(['kelas.jurusan'])->findOrFail($id_pembelajaran);

        $jurusan = Jurusan::all();
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();
        $kelas = $pembelajaran->kelas; // Perbaikan: Ambil kelas dari data pembelajaran
        $wakel = Wakel::all();
        $thajaran = TahunAjaran::all();
        $mapel = Mapel::all();
        $siswa = Siswa::with(['kelas.jurusan'])->where('kelas_id', $kelas->id)->get(); // Ambil siswa berdasarkan kelas

        return view('wakel.nilai.hasilkelola', compact('kelolanilai', 'pembelajaran', 'jurusan', 'kelas', 'kelas_X', 'kelas_XI', 'kelas_XII', 'wakel', 'thajaran', 'mapel', 'siswa'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate(Nilai::rules(), Nilai::$messages);

        $attendance = new Nilai($validatedData);
        $attendance->save();

        $id_pembelajaran = $attendance->pembelajaran_id;

        return redirect()->route('wakel.nilai.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
            ->with('suksestambah', 'Nilai berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input menggunakan aturan dan pesan dari model Nilai
        $validatedData = $request->validate(Nilai::rules($id), Nilai::$messages);

        // Temukan nilai berdasarkan ID dan perbarui
        $nilai = Nilai::findOrFail($id);
        $nilai->update($validatedData);

        return redirect()->back()->with('suksesedit', 'Data Nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $pembelajaran_id = $nilai->pembelajaran_id;

        $nilai->delete();

        return redirect()->route('wakel.nilai.hasilkelola', ['id_pembelajaran' => $pembelajaran_id])->with('success', 'Nilai berhasil dihapus');
    }

    public function byClass($kelas)
    {
        $kelasData = Kelas::findOrFail($kelas);
        $nilai = Nilai::where('kelas_id', $kelas)->get();
        return view('admin.result.byclass', compact('kelasData', 'nilai'));
    }

    public function export($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        // Ambil informasi dari kelas
        $kelasTingkat = $kelas->kelas_tingkat; // Pastikan 'kelas_tingkat' adalah kolom yang menyimpan tingkat kelas
        $jurusanId = $kelas->jurusan->kode_jurusan; // Misalkan 'jurusan_id' menyimpan ID jurusan
        $rombel = $kelas->rombel; // Pastikan 'rombel' adalah kolom yang menyimpan rombel

        // Format nama file
        $fileName = 'Nilai Siswa' . ' ' . $kelasTingkat . '-' .  $jurusanId . '-' . $rombel . '.xlsx';

        // Ekspor data
        return Excel::download(new NilaiExport($kelas_id), $fileName);
    }


    public function exportAll($kelas_id)
    {
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        $presensi = Presensi::whereIn('nis', $siswa->pluck('nis'))->get();

        $kelas = Kelas::with('pembelajaran.mapel', 'pembelajaran.nilai', 'jurusan')->findOrFail($kelas_id);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $wakel = Wakel::find($kelas->wakel_id);
        $thajaran = TahunAjaran::find($kelas->thajaran_id);

        $data = [
            'kelas' => $kelas,
            'presensi' => $presensi,
            'siswa' => $siswa,
            'wakel' => $wakel,
            'thajaran' => $thajaran,

        ];

        $pdf = Pdf::loadView('pdf.transkrip', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Transkrip_' . $kelas->kelas_tingkat . '-' . $kelas->jurusan->kode_jurusan . '.pdf';

        return $pdf->download($fileName);
    }
}
