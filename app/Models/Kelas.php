<?php

namespace App\Models;

use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Roman;

class Kelas extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kelas';
    protected $table = 'kelas';
    protected $fillable = ['id_kelas','kelas_tingkat', 'jurusan_id', 'rombel_id'];
    protected $casts = [
        'id_kelas' => 'string'
    ];
    
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }
    
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'id_rombel');
    }

    public function wakel()
    {
        return $this->hasOne(Wakel::class, 'kelas_id', 'id_kelas');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id_kelas');
    }

}