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
    public function index(Request $request)
    {
        $query = Exam::with('gradeClass')->latest();

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $exams = $query->paginate(20);

        try {
            $subjects = Exam::select('subject')
                ->whereNotNull('subject')
                ->where('subject', '!=', '')
                ->distinct()
                ->orderBy('subject')
                ->pluck('subject');
        } catch (\Throwable $e) {
            $subjects = collect();
        }

        $grades = ['6','7','8','9','10','11','O/L','A/L'];

        return view('admin.exams.index', compact('exams', 'subjects', 'grades'));
    }

    public function create()
    {
        $gradeClasses = GradeClass::where('is_active', true)
            ->orderBy('subject')->orderBy('grade')->get();
        $grades   = ['6','7','8','9','10','11','O/L','A/L'];
        $subjects = ['ICT','English','Mathematics','Science'];

        return view('admin.exams.create', compact('gradeClasses', 'grades', 'subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'subject'        => 'required|string|max:100',
            'grade'          => 'required|string|max:20',
            'type'           => 'required|in:term_test,mid_year,final,mock,other',
            'exam_date'      => 'nullable|date',
            'total_marks'    => 'required|integer|min:1|max:1000',
            'pass_marks'     => 'required|integer|min:1|max:1000',
            'grade_class_id' => 'nullable|exists:grade_classes,id',
            'is_published'   => 'boolean',
            'description'    => 'nullable|string',
        ]);

        $data['is_published'] = $request->boolean('is_published');

        Exam::create($data);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam created successfully!');
    }

    public function edit(Exam $exam)
    {
        $gradeClasses = GradeClass::where('is_active', true)
            ->orderBy('subject')->orderBy('grade')->get();
        $grades   = ['6','7','8','9','10','11','O/L','A/L'];
        $subjects = ['ICT','English','Mathematics','Science'];

        return view('admin.exams.edit', compact('exam', 'gradeClasses', 'grades', 'subjects'));
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'subject'        => 'required|string|max:100',
            'grade'          => 'required|string|max:20',
            'type'           => 'required|in:term_test,mid_year,final,mock,other',
            'exam_date'      => 'nullable|date',
            'total_marks'    => 'required|integer|min:1|max:1000',
            'pass_marks'     => 'required|integer|min:1|max:1000',
            'grade_class_id' => 'nullable|exists:grade_classes,id',
            'is_published'   => 'boolean',
            'description'    => 'nullable|string',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $exam->update($data);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully!');
    }

    public function manage(Exam $exam)
    {
        $exam->load('gradeClass');
        $results  = $exam->results()->with('user')->orderBy('marks', 'desc')->get();
        $students = User::where('user_type', 'student')->orderBy('name')->get();

        return view('admin.results.index', compact('exam', 'results', 'students'));
    }

    public function saveResults(Request $request, Exam $exam)
    {
        $request->validate(['results' => 'array']);

        foreach ($request->results as $row) {
            if (!isset($row['user_id']) || $row['marks'] === '') continue;

            $marks      = $row['marks'];
            $pct        = ($marks / $exam->total_marks) * 100;
            $grade_letter = match(true) {
                $pct >= 75   => 'A',
                $pct >= 65   => 'B',
                $pct >= 55   => 'C',
                $pct >= $exam->pass_marks => 'S',
                default      => 'W',
            };

            Result::updateOrCreate(
                ['user_id' => $row['user_id'], 'exam_id' => $exam->id],
                [
                    'marks'        => $marks,
                    'grade_letter' => $grade_letter,
                    'status'       => $marks >= $exam->pass_marks ? 'pass' : 'fail',
                    'remarks'      => $row['remarks'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Results saved!');
    }

    public function togglePublish(Exam $exam)
    {
        $exam->update(['is_published' => !$exam->is_published]);
        return back()->with('success', $exam->is_published ? 'Results published.' : 'Results unpublished.');
    }

    public function destroy(Exam $exam)
    {
        $exam->results()->delete();
        $exam->delete();
        return back()->with('success', 'Exam deleted.');
    }
}