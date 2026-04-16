<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineClass extends Model
{
    protected $fillable = [
        'grade_class_id', 'title', 'description',
        'join_url', 'platform', 'scheduled_at',
        'duration_minutes', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'is_active'    => 'boolean',
        ];
    }

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public function getIsLiveAttribute(): bool
    {
        $now = now();
        $end = $this->scheduled_at->copy()->addMinutes($this->duration_minutes);
        return $now->between($this->scheduled_at, $end);
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->scheduled_at->isFuture();
    }

    public function getPlatformIconAttribute(): string
    {
        return match($this->platform) {
            'zoom'     => 'fa-video',
            'facebook' => 'fa-brands fa-facebook',
            default    => 'fa-brands fa-google',
        };
    }
}