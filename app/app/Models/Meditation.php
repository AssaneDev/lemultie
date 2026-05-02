<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meditation extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'audio_file', 'video_file',
        'thumbnail', 'duration_seconds', 'type', 'theme',
        'is_active', 'is_premium', 'listen_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'listen_count' => 'integer',
        'duration_seconds' => 'integer',
    ];
}
