<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\GradeClass;
use App\Models\Teacher;
use App\Models\Video;
use App\Models\GalleryAlbum;
use App\Models\OnlineClass;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses  = Course::with('category')->where('is_featured', true)->where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $categories       = CourseCategory::where('is_active', true)->withCount('courses')->orderBy('sort_order')->get();
        $latestVideos     = Video::where('is_featured', true)->where('is_active', true)->orderByDesc('created_at')->take(3)->get();
        $upcomingClasses  = OnlineClass::with('gradeClass')->where('status', 'upcoming')->where('scheduled_at', '>=', now())->orderBy('scheduled_at')->take(3)->get();
        $teachers         = Teacher::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        $stats = [
            'students'  => \App\Models\User::where('user_type', 'student')->count() ?: 500,
            'courses'   => Course::where('is_active', true)->count(),
            'years'     => max(1, now()->year - 2018),
            'graduates' => 1200,
        ];

        return view('pages.home.index', compact(
            'featuredCourses', 'categories', 'latestVideos', 'upcomingClasses', 'stats', 'teachers'
        ));
    }

    public function contact()
    {
        return view('pages.contact.index');
    }

    public function sendEnquiry(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:100',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        Enquiry::create($validated);

        return back()->with('success', 'Thank you! Your message has been sent. We will contact you soon.');
    }

    public function search(Request $request)
    {
        $query   = $request->input('q', '');
        $results = collect();

        if (strlen($query) >= 2) {
            $courses = Course::where('is_active', true)
                ->where(fn($q) => $q->where('title', 'like', "%{$query}%")->orWhere('short_description', 'like', "%{$query}%"))
                ->take(5)->get()->map(fn($c) => ['type' => 'Course', 'title' => $c->title, 'url' => route('courses.show', $c->slug), 'icon' => 'fa-book']);

            $classes = GradeClass::where('is_active', true)
                ->where(fn($q) => $q->where('grade', 'like', "%{$query}%")->orWhere('subject', 'like', "%{$query}%"))
                ->take(5)->get()->map(fn($c) => ['type' => 'Class', 'title' => $c->full_name, 'url' => route('grade.show', $c->slug), 'icon' => 'fa-chalkboard-teacher']);

            $results = $courses->merge($classes);
        }

        return view('pages.home.search', compact('query', 'results'));
    }
}