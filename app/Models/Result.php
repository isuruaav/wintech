<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'exam_id', 'student_id', 'marks_obtained', 'grade', 'remarks',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getPercentageAttribute(): float
    {
        if (!$this->exam || $this->exam->total_marks == 0) return 0;
        return round(($this->marks_obtained / $this->exam->total_marks) * 100, 1);
    }

    public function getLetterGradeAttribute(): string
    {
        $p = $this->percentage;
        if ($p >= 75) return 'A';
        if ($p >= 65) return 'B';
        if ($p >= 55) return 'C';
        if ($p >= 35) return 'S';
        return 'F';
    }

    public function getGradeColorAttribute(): string
    {
        return match($this->letter_grade) {
            'A' => 'badge-active',
            'B' => 'bg-blue-100 text-blue-700',
            'C' => 'badge-pending',
            'S' => 'bg-purple-100 text-purple-700',
            default => 'badge-inactive',
        };
    }
}
