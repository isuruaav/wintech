<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherAdminController extends Controller
{
    public function index()
    {
        $teachers = Teacher::withCount('gradeClasses')->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:200',
            'subjects'   => 'nullable|string|max:300',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:200',
            'photo'      => 'nullable|image|max:2048',
            'bio'        => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        Teacher::create($data);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:200',
            'subjects'   => 'nullable|string|max:300',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:200',
            'photo'      => 'nullable|image|max:2048',
            'bio'        => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($teacher->photo) Storage::disk('public')->delete($teacher->photo);
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function toggleStatus(Teacher $teacher)
    {
        $teacher->update(['is_active' => !$teacher->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo) Storage::disk('public')->delete($teacher->photo);
        // Grade classes ලේ teacher_id null set කරනවා
        $teacher->gradeClasses()->update(['teacher_id' => null]);
        $teacher->delete();
        return back()->with('success', 'Teacher deleted.');
    }
}