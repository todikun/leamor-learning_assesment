<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'stimulus'=>'array',
        'opsi_jawaban'=>'array',
        'kunci_jawaban'=>'array',
    ];

    public function Soal()
    {
        return $this->belongsTo('App\Models\Soal', 'soal_id', 'id');
    }

    public function TipeSoal()
    {
        return $this->belongsTo('App\Models\TipeSoal', 'tipe_soal_id', 'id');
    }
}
