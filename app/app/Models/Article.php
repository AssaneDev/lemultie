<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content',
        'image', 'video_url', 'type', 'is_published', 'is_premium', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_premium' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
