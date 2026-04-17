<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'user_id', 'exam_id', 'marks', 'grade_letter', 'status', 'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function getGradeColorAttribute(): string
    {
        return match($this->grade_letter) {
            'A'     => 'text-emerald-600 bg-emerald-50',
            'B'     => 'text-blue-600 bg-blue-50',
            'C'     => 'text-sky-600 bg-sky-50',
            'S'     => 'text-amber-600 bg-amber-50',
            'W'     => 'text-red-600 bg-red-50',
            default => 'text-slate-600 bg-slate-50',
        };
    }
}