<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Jurusan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'jurusan';
    protected $fillable = ['kode_jurusan', 'nama_jurusan']; 

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'jurusan_id', 'id');
    }

    public static function getStoreRules()
    {
        return [
            'kode_jurusan' => 'required|string',
            'nama_jurusan' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
        ];
    }

    public static function getRules()
    {
        return [
            'kode_jurusan' => 'required|string',
            'nama_jurusan' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
        ];
    }

    public static $messages = [
        'kode_jurusan.required' => 'Kode Jurusan Jurusan harus diisi',
        'nama_jurusan.required' => 'Nama Jurusan harus diisi',
        'nama_jurusan.regex' => 'Nama Jurusan hanya boleh mengandung huruf dan spasi.',
        'nama_jurusan.max' => 'Nama Jurusan tidak boleh lebih dari 100 karakter.',
    ];
}
