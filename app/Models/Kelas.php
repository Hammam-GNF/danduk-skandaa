<?php

namespace App\Models;

use App\Models\Jurusan;
use App\Models\Siswa;
use App\Rules\UniqueRombelPerJurusan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_kelas';
    protected $table = 'kelas';
    protected $fillable = ['id_kelas', 'kelas_tingkat', 'jurusan_id', 'rombel'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }

    public function wakel()
    {
        return $this->hasOne(Wakel::class, 'nip', 'nip');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'nis', 'nis');
    }

    public static function getRules()
    {
        return [
            'kelas_tingkat' => 'required',
            'jurusan_id' => 'required',
            'rombel' => ['required', new UniqueRombelPerJurusan(request('kelas_tingkat'), request('jurusan_id'))],
        ];
    }

    public static $messages = [
        'kelas_tingkat.required' => 'Data tidak boleh kosong',
        'jurusan_id.required' => 'Data tidak boleh kosong',
        'rombel.required' => 'Rombel tidak boleh kosong',
        'rombel.unique_rombel_per_jurusan' => 'Rombel sudah ada untuk kombinasi kelas_tingkat dan jurusan_id yang sama.',
    ];
}