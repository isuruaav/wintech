<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'platform', 'join_url',
        'scheduled_at', 'duration_minutes', 'status',
        'grade_class_id', 'is_active',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_active'    => 'boolean',
    ];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public function getPlatformIconAttribute()
    {
        return match($this->platform) {
            'zoom'         => 'fa-video',
            'google_meet'  => 'fa-video',
            'teams'        => 'fa-video',
            default        => 'fa-video',
        };
    }
}