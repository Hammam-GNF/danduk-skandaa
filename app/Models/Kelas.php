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
    protected $primaryKey = 'id';
    protected $table = 'kelas';
    protected $fillable = ['id','kelas_tingkat','rombel_id', 'jurusan_id'];
    
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }
    
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'id');
    }

    public function wakel()
    {
        return $this->hasMany(Wakel::class, 'kelas_id', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id', 'id_kelas');
    }

}