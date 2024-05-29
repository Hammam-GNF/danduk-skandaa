<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ortu extends Model
{
    use HasFactory;

    protected $primaryKey = 'nama_ayah';
    protected $table = 'ortu';
    protected $fillable = ['nama_ayah', 'no_hp', 'alamat', 'ttl', 'pekerjaan'];
    protected $casts = [
        'nama_ayah' => 'string'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}