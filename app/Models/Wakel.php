<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wakel extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nip';
    protected $table = 'wakel';
    protected $fillable = ['nip', 'nama_wakel', 'jurusan_id', 'kelas_id'];
    protected $casts = [
        'nip' => 'string'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}