<?php

namespace App\Models;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wakel extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nip';
    protected $table = 'wakel';
    protected $fillable = ['nip', 'kelas_id', 'nama_wakel', 'rombel'];
    protected $casts = [
        'nip' => 'string',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }
    
}