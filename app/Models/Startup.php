<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    protected $fillable = [
        'name', 'logo', 'link', 'category', 'category_sub', 'founder', 'location'
    ];
}


