<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nis';
    protected $table = 'siswa';
    protected $fillable = ['nis', 'nama_siswa', 'kelas_id', 'rombel_id'];
    protected $casts = [
        'nis' => 'string'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }
    public function ortu()
    {
        return $this->hasMany(Ortu::class, 'nama_ayah', 'nama_ayah');
    }
    
}