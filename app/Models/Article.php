<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author',
        'published_at',
        'url',
        'image_url',
        'category',
        'event',
    ];

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}
