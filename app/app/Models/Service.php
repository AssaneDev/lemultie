<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'category',
        'price', 'image', 'audio_preview', 'is_active', 'is_premium', 'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'price' => 'decimal:2',
    ];
}
