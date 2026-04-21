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
    $subjects = ['ICT','English','Mathematics','Science'];
    $days     = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    return view('admin.classes.create', compact('teachers', 'grades', 'subjects', 'days'));
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

        $data['is_active'] = $request->boolean('is_active', true);
        $data['slug']      = Str::slug($data['subject'] . '-grade-' . $data['grade'] . '-' . uniqid());

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('classes', 'public');
        }

        $gradeClass = GradeClass::create($data);

        if ($request->filled('schedules')) {
            foreach ($request->schedules as $schedule) {
                if (!empty($schedule['day'])) {
                    $gradeClass->schedules()->create([
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

    public function edit($class)
    {
        $gradeClass = GradeClass::findOrFail($class);
        $teachers   = Teacher::where('is_active', true)->orderBy('name')->get();
        $grades     = ['6','7','8','9','10','11','O/L','A/L'];
        $subjects   = ['ICT','English','Mathematics','Science'];
        $days       = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $schedules  = $gradeClass->schedules()->orderBy('day')->get();

        return view('admin.classes.edit', [
            'class'      => $gradeClass,
            'gradeClass' => $gradeClass,
            'teachers'   => $teachers,
            'grades'     => $grades,
            'subjects'   => $subjects,
            'days'       => $days,
            'schedules'  => $schedules,
        ]);
    }

    public function update(Request $request, $class)
    {
        $gradeClass = GradeClass::findOrFail($class);

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

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('classes', 'public');
        }

        $gradeClass->update($data);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Grade class updated!');
    }

    public function toggleStatus($class)
    {
        $gradeClass = GradeClass::findOrFail($class);
        $gradeClass->update(['is_active' => !$gradeClass->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function destroy($class)
    {
        $gradeClass = GradeClass::findOrFail($class);
        $gradeClass->schedules()->delete();
        $gradeClass->delete();
        return back()->with('success', 'Grade class deleted.');
    }

    public function addSchedule(Request $request, $class)
    {
        $gradeClass = GradeClass::findOrFail($class);

        $request->validate([
            'day'        => 'required|string',
            'start_time' => 'required|string',
            'end_time'   => 'required|string',
        ]);

        $gradeClass->schedules()->create([
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'venue'      => $request->venue,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Schedule added.');
    }

    public function removeSchedule($class, $schedule)
    {
        $gradeClass      = GradeClass::findOrFail($class);
        $scheduleRecord  = ClassSchedule::where('id', $schedule)
                            ->where('grade_class_id', $gradeClass->id)
                            ->firstOrFail();
        $scheduleRecord->delete();
        return back()->with('success', 'Schedule removed.');
    }
}