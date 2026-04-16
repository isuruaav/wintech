<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;

class CourseController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::with(['courses' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])->get();
        $courses    = Course::where('is_active', true)->with('category')->orderBy('sort_order')->get();
        return view('pages.course.index', compact('categories', 'courses'));
    }

    public function show(Course $course)
    {
        abort_if(!$course->is_active, 404);
        $related = Course::where('is_active', true)
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)->get();
        return view('pages.course.show', compact('course', 'related'));
    }
}