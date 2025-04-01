<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    protected $fillable = [
        'original_image',
        'processed_image',
        'settings',
        'user_id'
    ];

    protected $casts = [
        'settings' => 'array'
    ];
} 