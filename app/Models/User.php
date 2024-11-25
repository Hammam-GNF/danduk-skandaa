<?php

namespace App\Models;

use App\Models\Admin\Kelas;
use App\Models\Admin\Pembelajaran;
use App\Models\Wakel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = ['role_id', 'jns_kelamin', 'nip', 'no_hp', 'username', 'password'];

    protected $primaryKey = 'id';

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function wakel()
    {
        return $this->hasMany(Wakel::class, 'user_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public static $rules = [
        'role_id' => 'required|exists:roles,id',
        'user_id' => 'required|exists:users,id',
    ];

    public static $messages = [
        'role_id.exists' => 'Role dengan ID yang diberikan tidak ditemukan.',
        'role_id.required' => 'Role wajib diisi.',
        'user_id.exists' => 'User dengan ID yang diberikan tidak ditemukan.',
        'user_id.required' => 'User wajib diisi.',
    ];

}
