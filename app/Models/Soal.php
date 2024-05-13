<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['pernyataan'=>'array'];
    protected $appends = ['is_mandiri_html'];

    public function Proyek()
    {
        return $this->belongsTo('App\Models\Proyek', 'proyek_id', 'id');
    }

    public function SoalDetail()
    {
        return $this->hasMany('App\Models\SoalDetail', 'soal_id', 'id'); 
    }

}
