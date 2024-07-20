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
        'feedback'=>'array',
        'nilai'=>'array',
    ];
    protected $appends = ['tanggal_format', 'jam_format'];

    public function getTanggalFormatAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->locale('id')->translatedFormat('j F Y');
    }

    public function getJamFormatAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->locale('id')->translatedFormat('H:i');
    }

    public function Soal()
    {
        return $this->belongsTo('App\Models\Soal', 'soal_id', 'id');
    }

    public function Siswa()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
