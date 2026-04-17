<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title', 'subject', 'grade', 'type', 'exam_date',
        'total_marks', 'pass_marks', 'grade_class_id',
        'is_published', 'description',
    ];

    protected $casts = [
        'exam_date'    => 'date',
        'is_published' => 'boolean',
    ];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'term_test' => 'Term Test',
            'mid_year'  => 'Mid Year',
            'final'     => 'Final Exam',
            'mock'      => 'Mock Exam',
            default     => 'Other',
        };
    }
}