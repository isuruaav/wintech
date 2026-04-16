<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\GradeClass;
use App\Models\User;
use App\Models\Result;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('gradeClass')->latest()->paginate(15);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $classes = GradeClass::where('is_active', true)->orderBy('grade')->get();
        return view('admin.exams.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'grade_class_id' => 'required|exists:grade_classes,id',
            'title'          => 'required|string|max:200',
            'total_marks'    => 'required|integer|min:1',
            'exam_date'      => 'nullable|date',
        ]);

        Exam::create($data);
        return redirect()->route('admin.exams.index')->with('success', 'Exam created.');
    }

    public function manage(Exam $exam)
    {
        $exam->load('gradeClass');
        $students = User::where('user_type', 'student')->where('is_active', true)->orderBy('name')->get();
        $results  = $exam->results()->pluck('marks_obtained', 'student_id');
        return view('admin.results.manage', compact('exam', 'students', 'results'));
    }

    public function saveResults(Request $request, Exam $exam)
    {
        $request->validate(['marks' => 'array']);

        foreach ($request->marks as $studentId => $marks) {
            if ($marks === null || $marks === '') continue;
            $percentage = ($marks / $exam->total_marks) * 100;
            $grade = $percentage >= 75 ? 'A' : ($percentage >= 65 ? 'B' : ($percentage >= 55 ? 'C' : ($percentage >= 35 ? 'S' : 'F')));

            Result::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $studentId],
                ['marks_obtained' => $marks, 'grade' => $grade]
            );
        }

        return back()->with('success', 'Results saved successfully.');
    }

    public function togglePublish(Exam $exam)
    {
        $exam->update(['is_published' => !$exam->is_published]);
        return back()->with('success', $exam->is_published ? 'Results published.' : 'Results unpublished.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Exam deleted.');
    }
}