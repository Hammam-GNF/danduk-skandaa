<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SiswaImport implements ToModel, WithValidation, SkipsEmptyRows
{
    private static $id_kelas;

    public static function setIdKelas($id)
    {
        self::$id_kelas = $id;
    }

    public function model(array $row)
    {
        $kelas = Kelas::find(self::$id_kelas);

        if (!$kelas) {
            throw new \Exception("Kelas dengan ID " . self::$id_kelas . " tidak ditemukan.");
        }

        if (empty($row[4])) {
            throw new \Exception("Kolom jurusan_id tidak boleh null.");
        }

        return new Siswa([
            'nis' => $row[0],
            'nama_siswa' => $row[1],
            'jns_kelamin' => $row[2],
            'kelas_id' => $kelas->id,
            'jurusan_id' => $row[4],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required|string',
            '*.1' => 'required|string',
            '*.2' => 'required|string',
            '*.4' => 'required|integer|exists:jurusans,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Kolom nis tidak boleh kosong.',
            '1.required' => 'Kolom nama_siswa tidak boleh kosong.',
            '2.required' => 'Kolom jns_kelamin tidak boleh kosong.',
            '4.required' => 'Kolom jurusan_id tidak boleh kosong.',
            '4.exists' => 'Jurusan tidak ditemukan di database.',
        ];
    }
}