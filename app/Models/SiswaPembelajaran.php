<?php

namespace App\Models;

use App\Models\Admin\Pembelajaran;
use App\Models\Admin\Siswa;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaPembelajaran extends Model
{
    use HasFactory;
    protected $table = "siswa_pembelajaran";
    protected $fillable = ['nis', 'pembelajaran_id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'pembelajaran_id');
    }

    public function pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class, 'id', 'nis');
    }
}
