<?php

namespace App\Models;

use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Wakel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'wakel';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function thajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thajaran_id', 'id');
    }

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'wakel_id', 'id');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function kelase()
    {
        return $this->hasOne(Kelas::class, 'wakel_id', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'wakel_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'wakel_id', 'id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'wakel_id', 'id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'wakel_id', 'id');
    }

    public static function getStoreRules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            Rule::unique('wakel')->where(function ($query) {
                return $query->where('kelas_id', request('kelas_id'));
            })->ignore(request()->route('id'))
        ];
    }

    public static function getUpdateRules($id)
    {
        return [
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            Rule::unique('wakel')->where(function ($query) {
                return $query->where('kelas_id', request('kelas_id'));
            })->ignore($id)
        ];
    }

    public static $messages = [
        'user_id.required' => 'User wajib diisi dan tidak boleh kosong.',
        'user_id.exists' => 'User dengan ID yang diberikan tidak ditemukan di database.',
        'kelas_id.required' => 'Kelas wajib diisi dan tidak boleh kosong.',
        'kelas_id.exists' => 'Kelas dengan ID yang diberikan tidak ditemukan di database.',
    ];
    

}
