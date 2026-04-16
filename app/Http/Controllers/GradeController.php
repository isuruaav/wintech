<?php

namespace App\Http\Controllers;

use App\Models\GradeClass;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $subjects = GradeClass::where('is_active', true)
            ->select('subject')->distinct()->orderBy('subject')->pluck('subject');

        $classesQuery = GradeClass::with('schedules')->where('is_active', true);

        if ($request->filled('subject')) {
            $classesQuery->where('subject', $request->subject);
        }
        if ($request->filled('grade')) {
            $classesQuery->where('grade', $request->grade);
        }
        if ($request->filled('medium')) {
            $classesQuery->where(function ($q) use ($request) {
                $q->where('medium', $request->medium)->orWhere('medium', 'both');
            });
        }

        $classes = $classesQuery->orderBy('sort_order')->get();
        $grouped = $classes->groupBy('subject');

        return view('pages.grade.index', compact('classes', 'subjects', 'grouped'));
    }

    public function show(string $slug)
    {
        $class    = GradeClass::with(['schedules', 'videos'])->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $upcoming = $class->onlineClasses()->where('status', 'upcoming')->where('scheduled_at', '>=', now())->orderBy('scheduled_at')->take(5)->get();

        return view('pages.grade.show', compact('class', 'upcoming'));
    }
}