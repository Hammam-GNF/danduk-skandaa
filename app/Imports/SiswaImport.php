<?php

namespace App\Imports;

use App\Models\Admin\Siswa;
use App\Models\Admin\Kelas;
use App\Models\Admin\Jurusan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\ValidationException;

class SiswaImport implements ToModel, WithValidation, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    protected $kelasId;
    protected $thajaranId;

    public function __construct($kelasId, $thajaranId)
    {
        $this->kelasId = $kelasId;
        $this->thajaranId = $thajaranId;
    }

    public function model(array $row)
    {
        Log::info('Proses import data siswa dimulai.', ['row' => $row]);

        $jurusan = Jurusan::where('kode_jurusan', $row['jurusan'])->first();

        if (!$jurusan) {
            Log::error('Jurusan dengan kode ' . $row['jurusan'] . ' tidak ditemukan.');
            throw new \Exception('Jurusan dengan kode ' . $row['jurusan'] . ' tidak ditemukan.');
        }

        $kelas = Kelas::find($this->kelasId);

        if (!$kelas) {
            Log::error('Kelas dengan ID ' . $this->kelasId . ' tidak ditemukan.');
            throw new \Exception('Kelas dengan ID ' . $this->kelasId . ' tidak ditemukan.');
        }

        if ($kelas->kelas_tingkat != $row['kelas'] ||
            $kelas->rombel != $row['rombel'] ||
            $kelas->jurusan_id != $jurusan->id) {
            Log::info('Data kelas tidak cocok dengan ID yang diberikan.', [
                'kelas_tingkat' => $kelas->kelas_tingkat,
                'rombel' => $kelas->rombel,
                'jurusan_id' => $kelas->jurusan_id,
            ]);
            
            Log::error('Kombinasi data tidak cocok dengan kelas ID ' . $this->kelasId);
            throw new \Exception('Kombinasi data tidak cocok dengan kelas yang diberikan.');
        }

        $existingRecord = Siswa::where('nis', $row['nis'])->first();
        if ($existingRecord) {
            Log::error('Data dengan NIS ' . $row['nis'] . ' sudah ada.');
            throw new \Exception('Data dengan NIS sudah ada.');
        }

        Log::info('Data siswa berhasil disiapkan untuk import.', [
            'nis' => $row['nis'],
            'nama_siswa' => $row['nama_siswa'],
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id,
            'status' => $row['status']
        ]);

        return new Siswa([
            'nis' => $row['nis'],
            'nama_siswa' => $row['nama_siswa'],
            'jns_kelamin' => $row['jns_kelamin'],
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id,
            'thajaran_id' => $this->thajaranId,
            'status' => $row['status'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nis' => [
                'required',
                'integer',
                'unique:siswa,nis',
            ],
            'nama_siswa' => 'required',
            'jns_kelamin' => 'required',
            'kelas' => 'required',
            'rombel' => 'required',
            'jurusan' => 'required|exists:jurusan,kode_jurusan',
            'status' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nis.required' => 'Kolom NIS wajib diisi.',
            'nis.integer' => 'Kolom NIS harus angka.',
            'nis.unique' => 'NIS sudah ada.',
            'nama_siswa.required' => 'Kolom Nama Siswa wajib diisi.',
            'jns_kelamin.required' => 'Kolom Jenis Kelamin wajib diisi.',
            'kelas.required' => 'Kolom Kelas Tingkat wajib diisi.',
            'rombel.required' => 'Kolom Rombel wajib diisi.',
            'jurusan.required' => 'Kolom Jurusan wajib diisi.',
            'jurusan.exists' => 'Jurusan yang dipilih tidak sesuai.',
            'status.required' => 'Kolom Status wajib diisi.',
        ];
    }

    public function onError(\Throwable $e)
    {
        Log::error('Gagal mengimport data: ' . $e->getMessage());
        session()->flash('errorimport', 'Gagal mengimport data: ' . $e->getMessage());
    }
}
