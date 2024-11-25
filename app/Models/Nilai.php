<?php

namespace App\Models;

use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use App\Models\Admin\Mapel;
use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'nilai';
    protected $guarded = ['id'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }

    public function thajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thajaran_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class, 'pembelajaran_id', 'id');
    }

    public function wakel()
    {
        return $this->belongsTo(Wakel::class, 'wakel_id', 'id');
    }

    public static function rules($id = null)
    {
        return [
            'nis' => [
                'required',
                'string',
                'exists:siswa,nis',
                function($attribute, $value, $fail) use ($id) {
                    $pembelajaran_id = request()->input('pembelajaran_id');
                    $existing = Nilai::where('nis', $value)
                                        ->where('pembelajaran_id', $pembelajaran_id)
                                        ->where('id', '<>', $id) // Tidak berlaku untuk update pada record yang sama
                                        ->exists();
                    
                    if ($existing) {
                        $fail('NIS sudah ada untuk pembelajaran ini.');
                    }
                },
            ],
            'mapel_id' => 'required',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas_id' => 'required',
            'pembelajaran_id' => 'required|exists:pembelajaran,id',
            'wakel_id' => 'required|exists:wakel,id',
            'thajaran_id' => 'required|exists:tahunajaran,id',
            'id_guru' => 'required|exists:users,id',
            'uh1' => 'nullable|integer|min:0|max:100',
            'uh2' => 'nullable|integer|min:0|max:100',
            'uh3' => 'nullable|integer|min:0|max:100',
            'uts' => 'nullable|integer|min:0|max:100',
            'uas' => 'nullable|integer|min:0|max:100',
        ];
    }

    public static $messages = [
        'nis.required' => 'NIS wajib diisi.',
        'nis.exists' => 'NIS yang dipilih tidak valid.',
        'mapel_id.required' => 'Mata Pelajaran Wajib diisi.',
        'kelas_id.required' => 'Kelas Wajib diisi.',
        'pembelajaran_id.required' => 'Pembelajaran wajib dipilih.',
        'pembelajaran_id.exists' => 'Pembelajaran yang dipilih tidak valid.',
        'thajaran_id.required' => 'Tahun Ajaran wajib dipilih.',
        'thajaran_id.exists' => 'Tahun Ajaran yang dipilih tidak valid.',
        'wakel_id.required' => 'Wakel wajib dipilih.',
        'wakel_id.exists' => 'Wakel yang dipilih tidak valid.',
        'jurusan_id.required' => 'Jurusan wajib diisi.',
        'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
    ];
}
