@extends('layouts.admin')
@section('title','Edit Student')
@section('page_title','Edit Student')
@section('breadcrumb','Students / Edit')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Index Number *</label>
                    <input type="text" name="index_number" value="{{ old('index_number', $student->index_number) }}" class="form-input" required>
                    @error('index_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">New Password <span class="text-slate-400 font-normal">(leave blank to keep)</span></label>
                    <input type="password" name="password" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Address</label>
                    <textarea name="address" rows="2" class="form-input resize-none">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Update Student</button>
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection