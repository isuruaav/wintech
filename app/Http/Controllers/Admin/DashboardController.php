<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\GradeClass;
use App\Models\OnlineClass;
use App\Models\Enquiry;
use App\Models\Exam;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students'        => User::where('user_type', 'student')->count(),
            'courses'         => Course::where('is_active', true)->count(),
            'grade_classes'   => GradeClass::where('is_active', true)->count(),
            'upcoming_classes'=> OnlineClass::where('scheduled_at', '>', now())->count(),
            'new_enquiries'   => Enquiry::where('status', 'new')->count(),
            'exams'           => Exam::count(),
        ];

        $recentStudents  = User::where('user_type', 'student')->latest()->take(5)->get();
        $upcomingClasses = OnlineClass::where('scheduled_at', '>', now())->orderBy('scheduled_at')->take(5)->get();
        $newEnquiries    = Enquiry::where('status', 'new')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentStudents', 'upcomingClasses', 'newEnquiries'));
    }
}