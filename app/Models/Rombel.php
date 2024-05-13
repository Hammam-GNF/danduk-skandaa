<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'rombel';
    protected $fillable = ['id','nama_rombel'];
    protected $casts = [
        'id' => 'string'
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id', 'rombel_id');
    }
}