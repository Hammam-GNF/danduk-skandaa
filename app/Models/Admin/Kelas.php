<?php

namespace App\Models\Admin;

use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Wakel;
use App\Rules\UniqueKelasCombination;
use App\Rules\UniqueRombelPerJurusan;
use App\Rules\UniqueWakel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Kelas extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'kelas';
    protected $fillable = ['kelas_tingkat', 'jurusan_id', 'rombel'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function wakel()
    {
        return $this->hasOne(Wakel::class, 'kelas_id', 'id');
    }

    public function wakele()
    {
        return $this->belongsTo(Wakel::class, 'wakel_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_kode', 'kode_mapel');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'kelas_id', 'id');
    }

    public function presensi(){
        return $this->hasMany(Presensi::class , "kelas_id");
    }

    public function nilai(){
        return $this->hasMany(Nilai::class , "kelas_id");
    }

    public static function storeRules()
    {
        return [
            'kelas_tingkat' => 'required|string|max:10',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => [
                'required',
                'integer',
                new UniqueKelasCombination(),
            ],
        ];
    }

    public static function getRules($id)
    {
        return [
            'kelas_tingkat' => 'required|string|max:10',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => [
                'required',
                'integer',
                new UniqueKelasCombination($id),
            ],
        ];
    }


    public static $messages = [
        'kelas_tingkat.required' => 'Kelas tingkat tidak boleh kosong',
        'kelas_tingkat.string' => 'Kelas tingkat harus berupa string',
        'kelas_tingkat.max' => 'Kelas tingkat maksimal 10 karakter',
        'jurusan_id.required' => 'Jurusan tidak boleh kosong',
        'jurusan_id.exists' => 'Jurusan tidak valid',
    ];

    public function checkRelatedData($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);

            // Contoh: Anda dapat menambahkan logika untuk memeriksa data terkait
            $hasRelatedData = false; // Ganti dengan logika sesuai kebutuhan Anda

            if ($hasRelatedData) {
                return response()->json([
                    'hasRelatedData' => true,
                    'relatedEntityType' => 'data terkait apa yang masih ada',
                ]);
            } else {
                return response()->json([
                    'hasRelatedData' => false,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
