<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_rombel';
    protected $table = 'rombel';
    protected $fillable = ['id_rombel'];
    protected $casts = [
        'id_rombel' => 'string'
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'rombel_id', 'id_rombel');
    }
    public function wakel()
    {
        return $this->hasMany(Wakel::class, 'nip', 'nip');
    }
}