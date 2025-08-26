<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    protected $fillable = [
        'name',
        'title',
        'role',
        'organization',
        'image_url',
        'detail',
        'event',
    ];
}

