<?php

namespace App\Models\Admin;

use App\Models\Presensi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Mapel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'mapel';
    protected $fillable = ['kode_mapel', 'nama_mapel'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'mapel_id', 'id');
    }
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'mapel_id', 'id');
    }
    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'mapel_id', 'id');
    }

    public static function getStoreRules()
    {
        return [
            'kode_mapel' => 'required|string|max:10',
            'nama_mapel' => 'required|string|max:50',
        ];
    }

    public static function getRules()
    {
        return [
            'kode_mapel' => 'required|string|max:10',
            'nama_mapel' => 'required|string|max:50',
        ];
    }

    public static $messages = [
        'kode_mapel.required' => 'Kode Mapel harus diisi',
        'kode_mapel.string' => 'Kode Mapel harus berupa teks',
        'kode_mapel.max' => 'Kode Mapel tidak boleh lebih dari 10 karakter',
        'nama_mapel.required' => 'Nama Mapel harus diisi',
        'nama_mapel.string' => 'Nama Mapel harus berupa teks',
        'nama_mapel.max' => 'Nama Mapel tidak boleh lebih dari 50 karakter',
    ];

}
