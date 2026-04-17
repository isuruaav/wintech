<?php

namespace App\Http\Controllers;

use App\Models\OnlineClass;
use App\Models\GradeClass;
use Illuminate\Http\Request;

class OnlineClassController extends Controller
{
    public function index(Request $request)
    {
        $liveNow = OnlineClass::with('gradeClass')
            ->where('status', 'live')
            ->get();

        $gradeClasses = GradeClass::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = OnlineClass::with('gradeClass')
            ->whereIn('status', ['upcoming', 'live'])
            ->where('scheduled_at', '>=', now());

        if ($request->filled('grade_class')) {
            $query->where('grade_class_id', $request->grade_class);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $classes = $query->orderBy('scheduled_at')->paginate(12);

        return view('pages.online-class.index', compact('classes', 'liveNow', 'gradeClasses'));
    }
}