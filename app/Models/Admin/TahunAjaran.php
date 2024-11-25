<?php

namespace App\Models\Admin;

use App\Models\Admin\Kelas;
use App\Models\Admin\Siswa;
use App\Models\Wakel;
use App\Models\Wakel\KelolaPresensi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'tahunajaran';
    protected $guarded = ['id'];

    public function wakel()
    {
        return $this->hasMany(Wakel::class, 'thajaran_id', 'id');
    }

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'thajaran_id', 'id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'thajaran_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'thajaran_id', 'id');
    }

    public static function rules($semester = null, $id = null)
    {
        $rules = [
            'thajaran' => 'required|string|max:20|unique:tahunajaran,thajaran,' . ($id ? $id : 'NULL') . ',id,semester,' . $semester,
            'semester' => 'required',
        ];

        return $rules;
    }

    public static $messages = [
        'thajaran.required' => 'Tahun Ajaran harus diisi',
        'thajaran.unique' => 'Tahun Ajaran tidak boleh sama untuk Semester yang sama',
        'thajaran.string' => 'Tahun Ajaran harus berupa teks.',
        'thajaran.max' => 'Tahun Ajaran tidak boleh lebih dari 20 karakter.',    
        'semester.required' => 'Semester harus diisi',
    ];

    public function getSemesterLabelAttribute()
    {
        if ($this->semester == 'Ganjil') {
            return 'Semester 1'; // Jika nilai semester adalah 1, maka ini semester ganjil
        } elseif ($this->semester == 'Genap') {
            return 'Semester 2'; // Jika nilai semester adalah 2, maka ini semester genap
        } else {
            return null; // Jika nilai semester tidak valid atau tidak terdefinisi
        }
    }
}
