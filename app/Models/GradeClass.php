<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade', 'subject', 'slug', 'description',
        'teacher', 'thumbnail', 'monthly_fee', 'mode', 'medium',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'monthly_fee' => 'decimal:2',
    ];

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function onlineClasses()
    {
        return $this->hasMany(OnlineClass::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->grade . ' — ' . $this->subject;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}