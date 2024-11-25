<?php

namespace App\Models;

use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\TahunAjaran;
use App\Models\Admin\Siswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'presensi';
    protected $guarded = ['id'];

    // Relasi dengan tabel Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    // Relasi dengan tabel Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    // Relasi dengan tabel TahunAjaran
    public function thajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thajaran_id', 'id');
    }

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }

    // Relasi dengan tabel Pembelajaran
    public function pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class, 'pembelajaran_id', 'id');
    }
    public function wakel()
    {
        return $this->belongsTo(Wakel::class, 'wakel_id', 'id');
    }

    // Validasi rules
    public static function rules($id = null)
    {
        return [
            'totalizin' => 'nullable|integer|min:0',
            'totalsakit' => 'nullable|integer|min:0',
            'totalalpa' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'mapel_id' => 'required|exists:mapel,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => [
                'required',
                'string',
                'exists:siswa,nis',
                function($attribute, $value, $fail) use ($id) {
                    $pembelajaran_id = request()->input('pembelajaran_id');
                    $existing = Presensi::where('nis', $value)
                                        ->where('pembelajaran_id', $pembelajaran_id)
                                        ->where('id', '<>', $id)
                                        ->exists();

                    if ($existing) {
                        $fail('NIS sudah ada untuk pembelajaran ini.');
                    }
                },
            ],
            'pembelajaran_id' => 'required|exists:pembelajaran,id',
            'wakel_id' => 'required|exists:wakel,id',
            'id_guru' => 'required|exists:users,id',
        ];
    }

    // Custom validation messages
    public static $messages = [
        'keterangan.string' => 'Keterangan harus berupa teks.',
        'mapel_id.required' => 'Mapel wajib diisi.',
        'mapel_id.exists' => 'Kode Mapel yang dipilih tidak valid.',
        'jurusan_id.required' => 'Jurusan wajib diisi.',
        'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
        'kelas_id.required' => 'Kelas wajib diisi.',
        'nis.required' => 'NIS wajib diisi.',
        'nis.exists' => 'NIS yang dipilih tidak valid.',
        'pembelajaran_id.required' => 'Pembelajaran wajib dipilih.',
        'pembelajaran_id.exists' => 'Pembelajaran yang dipilih tidak valid.',
        'wakel_id.required' => 'Wakel wajib dipilih.',
        'wakel_id.exists' => 'Wakel yang dipilih tidak valid.',
    ];
}
