<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['pernyataan'=>'array'];

    public function Proyek()
    {
        return $this->belongsTo('App\Models\Proyek', 'proyek_id', 'id');
    }
}
