<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSiswa extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'pernyataan'=>'array',
        'jawaban'=>'array',
        'nilai'=>'array',
    ];

    public function Soal()
    {
        return $this->belongsTo('App\Models\Soal', 'soal_id', 'id');
    }

    public function Siswa()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
