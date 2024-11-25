<?php

namespace App\Models;

use App\Models\Wakel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['id','level'];
    protected $table = 'role';

    public function user()
    {
        return $this->hasMany(User::class, 'role_id','id');
    }
    // public function wakel()
    // {
    //     return $this->hasOne(Wakel::class, 'role_id','id');
    // }
};