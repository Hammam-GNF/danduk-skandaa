<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nis';
    protected $table = 'siswa';
    protected $fillable = ['nis', 'nama_siswa', 'jns_kelamin', 'jurusan_id', 'rombel'];
    protected $casts = [
        'nis' => 'string',
    ];
    
    public function jurusan()
    {
        return $this->belongsTo(Kelas::class, 'jurusan_id', 'id_jurusan');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }
    
    public static $rules = 
    [
        'nis' => 'required',
        'nama_siswa' => 'required',
        'jns_kelamin' => 'required',
        'jurusan_id' => 'required',
        'rombel' => 'required',
    ];

    public static $messages = [
        'nis.required' => 'Data tidak boleh kosong',
        'nama_siswa.required' => 'Data tidak boleh kosong',
        'jns_kelamin.required' => 'Rombel tidak boleh kosong',
        'jurusan_id.required' => 'Rombel tidak boleh kosong',
        'rombel.required' => 'Rombel tidak boleh kosong',
    ];
}