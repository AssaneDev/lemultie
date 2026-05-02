<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'price', 'image',
        'video_intro', 'duration_hours', 'max_students', 'level',
        'is_active', 'is_premium', 'modules',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'price' => 'decimal:2',
        'modules' => 'array',
    ];

    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }
}
