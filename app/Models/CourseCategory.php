<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $fillable = ['name', 'icon', 'color', 'sort_order'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }
}