<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    protected $fillable = [
        'name',
        'category',
        'file_path',
        'thumbnail_path'
    ];
} 