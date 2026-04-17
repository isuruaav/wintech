<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineClass;
use App\Models\GradeClass;
use Illuminate\Http\Request;

class OnlineClassAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = OnlineClass::with('gradeClass')->latest('scheduled_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $classes = $query->paginate(20);
        return view('admin.online-classes.index', compact('classes'));
    }

    public function create()
    {
        $gradeClasses = GradeClass::where('is_active', true)->orderBy('subject')->orderBy('grade')->get();
        return view('admin.online-classes.create', compact('gradeClasses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'platform'         => 'required|in:zoom,google_meet,teams,other',
            'join_url'         => 'required|url',
            'scheduled_at'     => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'status'           => 'required|in:upcoming,live,ended',
            'grade_class_id'   => 'nullable|exists:grade_classes,id',
            'is_active'        => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        OnlineClass::create($data);

        return redirect()->route('admin.online-classes.index')
            ->with('success', 'Online class added successfully!');
    }

    public function edit(OnlineClass $onlineClass)
    {
        $gradeClasses = GradeClass::where('is_active', true)->orderBy('subject')->orderBy('grade')->get();
        return view('admin.online-classes.edit', compact('onlineClass', 'gradeClasses'));
    }

    public function update(Request $request, OnlineClass $onlineClass)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'platform'         => 'required|in:zoom,google_meet,teams,other',
            'join_url'         => 'required|url',
            'scheduled_at'     => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'status'           => 'required|in:upcoming,live,ended',
            'grade_class_id'   => 'nullable|exists:grade_classes,id',
            'is_active'        => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $onlineClass->update($data);

        return redirect()->route('admin.online-classes.index')
            ->with('success', 'Online class updated successfully!');
    }

    public function destroy(OnlineClass $onlineClass)
    {
        $onlineClass->delete();
        return back()->with('success', 'Online class deleted.');
    }

    public function toggleStatus(OnlineClass $onlineClass)
    {
        $onlineClass->update(['is_active' => !$onlineClass->is_active]);
        return back()->with('success', 'Status updated.');
    }
}