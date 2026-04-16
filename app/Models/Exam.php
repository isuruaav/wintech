<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'grade_class_id', 'title', 'total_marks',
        'exam_date', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'exam_date'    => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}