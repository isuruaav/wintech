<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeClass;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GradeClassAdminController extends Controller
{
    private array $grades = [
        'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'O/L', 'A/L',
    ];

    private array $subjects = ['English', 'ICT', 'Mathematics', 'Science'];

    private array $days = [
        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
    ];

    public function index(Request $request)
    {
        $query = GradeClass::with('schedules');

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $classes  = $query->orderBy('sort_order')->orderBy('subject')->get();
        $subjects = $this->subjects;
        $grades   = $this->grades;

        return view('admin.classes.index', compact('classes', 'subjects', 'grades'));
    }

    public function create()
    {
        $grades   = $this->grades;
        $subjects = $this->subjects;
        $days     = $this->days;

        return view('admin.classes.create', compact('grades', 'subjects', 'days'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'grade'       => 'required|string|max:50',
            'subject'     => 'required|string|max:100',
            'teacher'     => 'required|string|max:200',
            'medium'      => 'required|in:english,sinhala,both',
            'mode'        => 'required|in:physical,online,both',
            'monthly_fee' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'thumbnail'   => 'nullable|image|max:2048',
            'sort_order'  => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $data['slug']      = Str::slug($data['grade'] . '-' . $data['subject']) . '-' . Str::random(4);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('classes', 'public');
        }

        $schedules = $request->input('schedules', []);
        unset($data['schedules']);

        $gradeClass = GradeClass::create($data);

        foreach ($schedules as $schedule) {
            if (!empty($schedule['day'])) {
                $gradeClass->schedules()->create(array_merge($schedule, ['is_active' => true]));
            }
        }

        return redirect()->route('admin.classes.index')->with('success', 'Grade class created successfully.');
    }

    public function edit(GradeClass $class)
    {
        $grades    = $this->grades;
        $subjects  = $this->subjects;
        $days      = $this->days;
        $schedules = $class->schedules()->get();

        return view('admin.classes.edit', compact('class', 'grades', 'subjects', 'days', 'schedules'));
    }

    public function update(Request $request, GradeClass $class)
    {
        $data = $request->validate([
            'grade'       => 'required|string|max:50',
            'subject'     => 'required|string|max:100',
            'teacher'     => 'required|string|max:200',
            'medium'      => 'required|in:english,sinhala,both',
            'mode'        => 'required|in:physical,online,both',
            'monthly_fee' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'thumbnail'   => 'nullable|image|max:2048',
            'sort_order'  => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('thumbnail')) {
            if ($class->thumbnail) Storage::disk('public')->delete($class->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('classes', 'public');
        }

        $class->update($data);

        return redirect()->route('admin.classes.index')->with('success', 'Grade class updated successfully.');
    }

    public function toggleStatus(GradeClass $class)
    {
        $class->update(['is_active' => !$class->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function destroy(GradeClass $class)
    {
        if ($class->thumbnail) Storage::disk('public')->delete($class->thumbnail);
        $class->delete();
        return back()->with('success', 'Grade class deleted.');
    }

    public function addSchedule(Request $request, GradeClass $class)
    {
        $data = $request->validate([
            'day'        => 'required|in:' . implode(',', $this->days),
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i',
            'venue'      => 'nullable|string|max:200',
        ]);

        $class->schedules()->create(array_merge($data, ['is_active' => true]));

        return back()->with('success', 'Schedule added.');
    }

    public function removeSchedule(GradeClass $class, ClassSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule removed.');
    }
}