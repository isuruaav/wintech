<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $results = $student->results()
            ->with(['exam.gradeClass'])
            ->whereHas('exam', fn($q) => $q->where('is_published', true))
            ->latest()
            ->get();

        return view('pages.student.results', compact('student', 'results'));
    }
}