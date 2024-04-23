<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpFile extends Model
{
    use HasFactory;
    protected $table = 'tmpfile';
    protected $guarded = [];
    public $timestamps = false;
}
