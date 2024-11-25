<?php
namespace App\Models\Admin;

use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\SiswaPembelajaran;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Pembelajaran extends Model
{
    use HasFactory;

    protected $table = 'pembelajaran';
    protected $guarded = ['id'];
    use HasFactory;

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }

    public function wakel()
    {
        return $this->belongsTo(Wakel::class, 'wakel_id', 'id');
    }

    public function thajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thajaran_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'pembelajaran_id', 'id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'pembelajaran_id', 'id');
    }

    public static function rules($id = null)
    {
        return [
            'mapel_id' => [
                'required',
                Rule::unique('pembelajaran')
                    ->where('kelas_id', request('kelas_id'))
                    ->where('thajaran_id', request('thajaran_id'))
                    ->ignore($id),
            ],
            'kelas_id' => 'required',
            'thajaran_id' => 'required',
        ];
    }

    public static $messages = [
        'thajaran_id.required' => 'Tahun Ajaran harus dipilih',
        'kelas_id.required' => 'Kelas harus dipilih',
        'mapel_id.required' => 'Mapel harus diisi',
        'mapel_id.unique' => 'Nama Mapel, Nama Kelas, dan Wali Kelas sudah ada',
    ];
}
