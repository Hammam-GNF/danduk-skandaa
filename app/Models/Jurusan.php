<?php

namespace App\Models;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jurusan';
    protected $table = 'jurusan';
    protected $fillable = ['id_jurusan','nama_jurusan'];
    protected $casts = [
        'id_jurusan' => 'string'
    ];
    
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id', 'id_jurusan');
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'nis', 'nis');
    }
}