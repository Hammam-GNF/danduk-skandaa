<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_siswa';
    protected $table = 'siswa';
    protected $fillable = ['id_siswa', 'nama', 'kelas_id'];
    protected $casts = [
        'id_siswa' => 'string'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }
}