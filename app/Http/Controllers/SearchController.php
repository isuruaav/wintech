<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\GradeClass;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query   = $request->get('q', '');
        $results = collect();

        if (strlen($query) >= 2) {
            $courses = Course::where('is_active', true)
                ->where(fn($q) => $q->where('title', 'like', "%$query%")->orWhere('description', 'like', "%$query%"))
                ->get()
                ->map(fn($c) => ['type' => 'Course', 'title' => $c->title, 'url' => route('courses.show', $c), 'icon' => 'fa-solid fa-book']);

            $classes = GradeClass::where('is_active', true)
                ->where(fn($q) => $q->where('subject', 'like', "%$query%")->orWhere('grade', 'like', "%$query%")->orWhere('teacher', 'like', "%$query%"))
                ->get()
                ->map(fn($c) => ['type' => 'Grade Class', 'title' => $c->full_name, 'url' => route('grade.show', $c), 'icon' => 'fa-solid fa-chalkboard-user']);

            $results = $courses->merge($classes);
        }

        return view('pages.home.search', compact('query', 'results'));
    }
}