<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeClass;
use App\Models\ClassSchedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GradeClassAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = GradeClass::with(['teacher', 'schedules'])->latest();

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $classes  = $query->paginate(20);
        $subjects = ['ICT', 'English', 'Mathematics', 'Science'];
        $grades   = ['6','7','8','9','10','11','O/L','A/L'];

        return view('admin.classes.index', compact('classes', 'subjects', 'grades'));
    }

    public function create()
    {
        $teachers = Teacher::where('is_active', true)->orderBy('name')->get();
        $grades   = ['6','7','8','9','10','11','O/L','A/L'];
        return view('admin.classes.create', compact('teachers', 'grades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:100',
            'grade'        => 'required|string|max:20',
            'teacher_id'   => 'nullable|exists:teachers,id',
            'teacher'      => 'nullable|string|max:255',
            'medium'       => 'required|in:english,sinhala,both',
            'mode'         => 'required|in:physical,online,both',
            'monthly_fee'  => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
            'is_active'    => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['slug']       = Str::slug($data['subject'] . '-grade-' . $data['grade'] . '-' . uniqid());

        $class = GradeClass::create($data);

        // Save schedules
        if ($request->filled('schedules')) {
            foreach ($request->schedules as $schedule) {
                if (!empty($schedule['day'])) {
                    $class->schedules()->create([
                        'day'        => $schedule['day'],
                        'start_time' => $schedule['start_time'] ?? null,
                        'end_time'   => $schedule['end_time'] ?? null,
                        'is_active'  => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.classes.index')
            ->with('success', 'Grade class created successfully!');
    }

    public function edit(GradeClass $gradeClass)
    {
        $teachers = Teacher::where('is_active', true)->orderBy('name')->get();
        $grades   = ['6','7','8','9','10','11','O/L','A/L'];
        return view('admin.classes.edit', compact('gradeClass', 'teachers', 'grades'));
    }

    public function update(Request $request, GradeClass $gradeClass)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:100',
            'grade'        => 'required|string|max:20',
            'teacher_id'   => 'nullable|exists:teachers,id',
            'teacher'      => 'nullable|string|max:255',
            'medium'       => 'required|in:english,sinhala,both',
            'mode'         => 'required|in:physical,online,both',
            'monthly_fee'  => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
            'is_active'    => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $gradeClass->update($data);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Grade class updated successfully!');
    }

    public function toggleStatus(GradeClass $gradeClass)
    {
        $gradeClass->update(['is_active' => !$gradeClass->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function destroy(GradeClass $gradeClass)
    {
        $gradeClass->schedules()->delete();
        $gradeClass->delete();
        return back()->with('success', 'Grade class deleted.');
    }

    public function addSchedule(Request $request, GradeClass $gradeClass)
    {
        $request->validate([
            'day'        => 'required|string',
            'start_time' => 'required|string',
            'end_time'   => 'required|string',
        ]);

        $gradeClass->schedules()->create([
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Schedule added.');
    }

    public function removeSchedule(GradeClass $gradeClass, ClassSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule removed.');
    }
}