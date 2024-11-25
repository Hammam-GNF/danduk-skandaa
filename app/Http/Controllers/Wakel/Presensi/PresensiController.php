<?php

namespace App\Http\Controllers\Wakel\Presensi;

use App\Exports\PresensiExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use App\Models\Wakel;
use App\Models\Presensi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    private function getTahunAjaranAktif()
    {
        return TahunAjaran::where('status', 'aktif')->first();
    }

    public function mengajar()
    {
        $userId = auth()->id(); 
        $roleId = auth()->user()->role_id;

        if ($roleId != 3) {
            abort(403, 'Unauthorized action.');
        }

        $wakel = Wakel::where('user_id', $userId)->first();

        if (!$wakel) {
            session()->flash('error', 'Tidak ada wakel yang terdaftar untuk user ini.');
            $pembelajaran = collect();
            $mapelWakel = collect();
        } else {
            $pembelajaran = Pembelajaran::where('id_guru', $userId)
                ->with(['mapel', 'kelas'])
                ->get();

            $namaWakel = $wakel->nama_wakel;

            $mapelWakel = $pembelajaran->map(function ($pembelajaran) use ($namaWakel) {
                return [
                    'id' => $pembelajaran->id,
                    'nama_mapel' => $pembelajaran->mapel->nama_mapel,
                    'kelas_tingkat' => $pembelajaran->kelas->kelas_tingkat,
                    'kode_jurusan' => $pembelajaran->kelas->jurusan->kode_jurusan,
                    'rombel' => $pembelajaran->kelas->rombel,
                    'nama_wakel' => $namaWakel,
                ];
            });
        }

        return view('wakel.mengajar', compact('pembelajaran', 'mapelWakel'));
    }

    public function indexwakel($id_pembelajaran)
    {
        $kelas = Kelas::with('jurusan')->find($id_pembelajaran);
        if (!$kelas) {
            abort(404, 'Kelas tidak ditemukan');
        }

        // Cek jika id kelas ada
        $idKelas = $kelas->id ?? null;

        $siswa = Siswa::where('kelas_id', $id_pembelajaran)->get();
        $wakel = Wakel::where('kelas_id', $id_pembelajaran)->firstOrFail();

        // $pembelajaran = Pembelajaran::where('kelas_id', $id)
        //     ->where('id_guru', $wakel->id_guru)
        //     ->with(['mapel', 'guru'])
        //     ->get();

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'mapel'])->findOrFail($id_pembelajaran);

        return view('wakel.presensi.presensi', compact('kelas', 'siswa', 'pembelajaran'));
    }

    public function kelola($id)
    {
        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'kelas.wakel', 'mapel', 'guru'])->findOrFail($id);
        $tahunAjaranAktif = $this->getTahunAjaranAktif();

        $kelas = $pembelajaran->kelas;
        $wakel = $kelas->wakel;
        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->where('thajaran_id', $tahunAjaranAktif->id)
            ->get();

        return view('wakel.presensi.kelola', compact('pembelajaran', 'wakel', 'kelas', 'siswa'));
    }

    public function hasilkelola($id_pembelajaran)
    {
        $kelolapresensi = Presensi::where('pembelajaran_id', $id_pembelajaran)
            ->with(['siswa', 'kelas', 'jurusan', 'thajaran', 'mapel'])
            ->get()
            ->groupBy('mapel.kode_mapel');

        $pembelajaran = Pembelajaran::with(['kelas.jurusan', 'mapel'])->findOrFail($id_pembelajaran);

        $jurusan = Jurusan::all();
        $kelas_X = Kelas::where('kelas_tingkat', 'X')->get();
        $kelas_XI = Kelas::where('kelas_tingkat', 'XI')->get();
        $kelas_XII = Kelas::where('kelas_tingkat', 'XII')->get();
        $wakel = Wakel::all();
        $thajaran = TahunAjaran::all();
        $kelas = $pembelajaran->kelas;
        $mapel = Mapel::all();
        $siswa = Siswa::with(['kelas.jurusan'])->where('kelas_id', $kelas->id)->get();

        return view('wakel.presensi.hasilkelola', compact(
            'kelolapresensi',
            'jurusan',
            'kelas_X',
            'kelas_XI',
            'kelas_XII',
            'kelas',
            'wakel',
            'thajaran',
            'pembelajaran',
            'mapel',
            'siswa'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(Presensi::rules(), Presensi::$messages);

        $attendance = new Presensi($validatedData);
        $attendance->save();

        $id_pembelajaran = $attendance->pembelajaran_id;

        return redirect()->route('wakel.presensi.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
            ->with('suksestambah', 'Data presensi berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input menggunakan aturan dan pesan dari model Presensi
        $validatedData = $request->validate(Presensi::rules($id), Presensi::$messages);
        // Temukan presensi berdasarkan ID dan perbarui
        $attendance = Presensi::findOrFail($id);
        $attendance->update($validatedData);

        return redirect()->back()->with('suksesedit', 'Data presensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Temukan data presensi berdasarkan ID
        $attendance = Presensi::find($id);

        // Jika data ditemukan, hapus dan redirect ke route hasilkelola
        if ($attendance) {
            $id_pembelajaran = $attendance->pembelajaran_id; // Ambil ID Pembelajaran dari data presensi
            $attendance->delete();

            // Redirect ke route hasilkelola dengan ID pembelajaran dan pesan sukses
            return redirect()->route('wakel.presensi.hasilkelola', ['id_pembelajaran' => $id_pembelajaran])
                ->with('success', 'Data presensi berhasil dihapus.');
        }

        // Jika data tidak ditemukan, redirect kembali dengan pesan error
        return redirect()->route('wakel.presensi.indexwakel', ['id' => $id])
            ->with('error', 'Data presensi tidak ditemukan.');
    }

    public function export($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        // Ambil informasi dari kelas
        $kelasTingkat = $kelas->kelas_tingkat; // Pastikan 'kelas_tingkat' adalah kolom yang menyimpan tingkat kelas
        $jurusanId = $kelas->jurusan->kode_jurusan; // Misalkan 'jurusan_id' menyimpan ID jurusan
        $rombel = $kelas->rombel; // Pastikan 'rombel' adalah kolom yang menyimpan rombel

        // Format nama file
        $fileName = 'Kehadiran Siswa' . ' ' . $kelasTingkat . '-' .  $jurusanId . '-' . $rombel . '.xlsx';

        return Excel::download(new PresensiExport($kelas_id), $fileName);
    }
}
