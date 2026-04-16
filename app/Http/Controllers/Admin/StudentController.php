<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = User::where('user_type', 'student')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('index_number', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->status === 'active',   fn($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn($q) => $q->where('is_active', false))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'nullable|email|unique:users,email',
            'index_number' => 'required|string|unique:users,index_number',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'password'     => 'required|string|min:6|confirmed',
        ]);

        $data['password']  = Hash::make($data['password']);
        $data['user_type'] = 'student';
        $data['is_active'] = true;

        User::create($data);
        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function edit(User $student)
    {
        abort_if($student->user_type !== 'student', 404);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'nullable|email|unique:users,email,' . $student->id,
            'index_number' => 'required|string|unique:users,index_number,' . $student->id,
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'password'     => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $student->update($data);
        return redirect()->route('admin.students.index')->with('success', 'Student updated.');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return back()->with('success', 'Student deleted.');
    }

    public function toggleActive(User $student)
    {
        $student->update(['is_active' => !$student->is_active]);
        return back()->with('success', 'Student status updated.');
    }

    public function approve(User $student)
    {
        $student->update([
            'reg_status' => 'approved',
            'is_active'  => true,
        ]);
        return back()->with('success', $student->name . ' approved successfully.');
    }

    public function reject(User $student)
    {
        $student->update([
            'reg_status' => 'rejected',
            'is_active'  => false,
        ]);
        return back()->with('success', $student->name . ' registration rejected.');
    }
}
