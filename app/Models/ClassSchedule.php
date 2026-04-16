<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = ['grade_class_id', 'day', 'start_time', 'end_time', 'venue'];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }
}
