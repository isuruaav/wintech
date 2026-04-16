<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title', 'description', 'video_url',
        'source', 'thumbnail', 'category',
        'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function getEmbedUrlAttribute(): string
    {
        if ($this->source === 'youtube') {
            preg_match('/(?:v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $this->video_url, $m);
            return isset($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] : $this->video_url;
        }
        return $this->video_url;
    }
}