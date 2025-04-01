<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'is_public'
    ];

    public function pictures()
    {
        return $this->hasMany(ProfilePicture::class);
    }
} 