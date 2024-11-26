<?php

namespace App\Models\Admin;

use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\SiswaPembelajaran;
use App\Models\Wakel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nis';
    protected $table = 'siswa';
    protected $fillable = [ 'nis', 'nama_siswa', 'jns_kelamin', 'wakel_id', 'kelas_id', 'status', 'thajaran_id'];
    
    public function thajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thajaran_id', 'id');
    }

    public function wakel()
    {
        return $this->belongsTo(Wakel::class, 'wakel_id', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class,'nis', 'nis');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'nis', 'nis');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'nis', 'nis');
    }

    public static $rules = [
        'nis' => 'required|unique:siswa,nis',
        'nama_siswa' => 'required|string|max:255',
        'jns_kelamin' => 'required|in:Laki-laki,Perempuan',
        'kelas_id' => 'required|exists:kelas,id',
        'status' => 'required|in:Aktif,NonAktif',
        'nama_ortu' => 'nullable|string|max:255',
        'nohp_ortu' => 'nullable|string|max:15',
        'alamat' => 'nullable|string',
    ];

    public static $messages = [
        'nis.required' => 'NIS wajib diisi.',
        'nis.unique' => 'NIS sudah ada.',
        'nama_siswa.required' => 'Nama siswa wajib diisi.',
        'jns_kelamin.required' => 'Jenis kelamin wajib diisi.',
        'thajaran_id.required' => 'Tahun Ajaran wajib diisi.',
        'thajaran_id.exists' => 'Tahun Ajaran tidak ditemukan.',
        'kelas_id.required' => 'Kelas wajib diisi.',
        'kelas_id.exists' => 'Kelas tidak ditemukan.',
        'status.required' => 'Status wajib diisi.',
    ];
}
