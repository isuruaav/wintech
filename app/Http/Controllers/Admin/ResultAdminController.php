<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class ResultAdminController extends Controller
{
    public function index(Exam $exam)
    {
        $results  = $exam->results()->with('user')->orderBy('marks', 'desc')->get();
        $students = User::where('user_type', 'student')->orderBy('name')->get();
        return view('admin.results.index', compact('exam', 'results', 'students'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'marks'        => 'required|numeric|min:0|max:' . $exam->total_marks,
            'remarks'      => 'nullable|string|max:500',
        ]);

        $marks       = $request->marks;
        $total       = $exam->total_marks;
        $pass        = $exam->pass_marks;
        $percentage  = ($marks / $total) * 100;

        $grade_letter = match(true) {
            $percentage >= 75 => 'A',
            $percentage >= 65 => 'B',
            $percentage >= 55 => 'C',
            $percentage >= $pass => 'S',
            default           => 'W',
        };

        Result::updateOrCreate(
            ['user_id' => $request->user_id, 'exam_id' => $exam->id],
            [
                'marks'        => $marks,
                'grade_letter' => $grade_letter,
                'status'       => $marks >= $pass ? 'pass' : 'fail',
                'remarks'      => $request->remarks,
            ]
        );

        return back()->with('success', 'Result saved!');
    }

    public function bulkStore(Request $request, Exam $exam)
    {
        $request->validate([
            'results'              => 'required|array',
            'results.*.user_id'    => 'required|exists:users,id',
            'results.*.marks'      => 'required|numeric|min:0|max:' . $exam->total_marks,
        ]);

        foreach ($request->results as $row) {
            $marks      = $row['marks'];
            $total      = $exam->total_marks;
            $pass       = $exam->pass_marks;
            $pct        = ($marks / $total) * 100;

            $grade_letter = match(true) {
                $pct >= 75 => 'A',
                $pct >= 65 => 'B',
                $pct >= 55 => 'C',
                $pct >= $pass => 'S',
                default    => 'W',
            };

            Result::updateOrCreate(
                ['user_id' => $row['user_id'], 'exam_id' => $exam->id],
                [
                    'marks'        => $marks,
                    'grade_letter' => $grade_letter,
                    'status'       => $marks >= $pass ? 'pass' : 'fail',
                    'remarks'      => $row['remarks'] ?? null,
                ]
            );
        }

        return back()->with('success', count($request->results) . ' results saved!');
    }

    public function destroy(Exam $exam, Result $result)
    {
        $result->delete();
        return back()->with('success', 'Result deleted.');
    }
}