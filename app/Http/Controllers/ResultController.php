<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Result::with('exam')
            ->where('user_id', $user->id)
            ->whereHas('exam', fn($q) => $q->where('is_published', true));

        if ($request->filled('subject')) {
            $query->whereHas('exam', fn($q) => $q->where('subject', $request->subject));
        }
        if ($request->filled('grade')) {
            $query->whereHas('exam', fn($q) => $q->where('grade', $request->grade));
        }

        $results = $query->latest()->get();

        // Stats
        $totalExams  = $results->count();
        $passCount   = $results->where('status', 'pass')->count();
        $avgMarks    = $totalExams ? round($results->avg('marks'), 1) : 0;
        $bestGrade   = $results->sortByDesc('marks')->first()?->grade_letter ?? '—';

        // Subjects for filter
        $subjects = Result::where('user_id', $user->id)
            ->whereHas('exam', fn($q) => $q->where('is_published', true))
            ->with('exam:id,subject')
            ->get()
            ->pluck('exam.subject')
            ->unique()
            ->filter()
            ->sort()
            ->values();

        $grades = ['6','7','8','9','10','11','O/L','A/L'];

        return view('pages.results.index', compact(
            'results', 'totalExams', 'passCount', 'avgMarks', 'bestGrade', 'subjects', 'grades'
        ));
    }
}