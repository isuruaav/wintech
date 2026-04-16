<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineClass;
use App\Models\GradeClass;
use Illuminate\Http\Request;

class OnlineClassController extends Controller
{
    public function index()
    {
        $classes = OnlineClass::with('gradeClass')->orderBy('scheduled_at', 'desc')->paginate(15);
        return view('admin.online-classes.index', compact('classes'));
    }

    public function create()
    {
        $gradeClasses = GradeClass::where('is_active', true)->orderBy('grade')->get();
        return view('admin.online-classes.create', compact('gradeClasses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'grade_class_id'   => 'nullable|exists:grade_classes,id',
            'title'            => 'required|string|max:200',
            'description'      => 'nullable|string',
            'join_url'         => 'required|url',
            'platform'         => 'required|in:google_meet,zoom,other',
            'scheduled_at'     => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'is_active'        => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        OnlineClass::create($data);
        return redirect()->route('admin.online-classes.index')->with('success', 'Online class created.');
    }

    public function edit(OnlineClass $onlineClass)
    {
        $gradeClasses = GradeClass::where('is_active', true)->orderBy('grade')->get();
        return view('admin.online-classes.edit', compact('onlineClass', 'gradeClasses'));
    }

    public function update(Request $request, OnlineClass $onlineClass)
    {
        $data = $request->validate([
            'grade_class_id'   => 'nullable|exists:grade_classes,id',
            'title'            => 'required|string|max:200',
            'description'      => 'nullable|string',
            'join_url'         => 'required|url',
            'platform'         => 'required|in:google_meet,zoom,other',
            'scheduled_at'     => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'is_active'        => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $onlineClass->update($data);
        return redirect()->route('admin.online-classes.index')->with('success', 'Updated successfully.');
    }

    public function destroy(OnlineClass $onlineClass)
    {
        $onlineClass->delete();
        return back()->with('success', 'Deleted.');
    }
}