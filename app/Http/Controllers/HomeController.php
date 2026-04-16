<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\GradeClass;
use App\Models\OnlineClass;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses  = Course::where('is_featured', true)->where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $gradeClasses     = GradeClass::where('is_active', true)->with('schedules')->orderBy('sort_order')->take(8)->get();
        $upcomingClasses  = OnlineClass::where('is_active', true)->where('scheduled_at', '>', now())->orderBy('scheduled_at')->take(4)->get();
        $settings         = SiteSetting::all()->pluck('value', 'key');

        return view('pages.home.index', compact('featuredCourses', 'gradeClasses', 'upcomingClasses', 'settings'));
    }
}