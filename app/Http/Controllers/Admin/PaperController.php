<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function index()
    {
        $papers = Paper::orderBy('sort_order')->paginate(15);
        return view('admin.papers.index', compact('papers'));
    }

    public function create()
    {
        return view('admin.papers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:200',
            'subject'   => 'nullable|string|max:100',
            'grade'     => 'nullable|string|max:50',
            'year'      => 'nullable|integer',
            'file'      => 'required|mimes:pdf|max:10240',
            'is_active' => 'boolean',
        ]);
        $data['file_path'] = $request->file('file')->store('papers', 'public');
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['file']);
        Paper::create($data);
        return redirect()->route('admin.papers.index')->with('success', 'Paper uploaded.');
    }

    public function edit(Paper $paper)
    {
        return view('admin.papers.edit', compact('paper'));
    }

    public function update(Request $request, Paper $paper)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:200',
            'subject'   => 'nullable|string|max:100',
            'grade'     => 'nullable|string|max:50',
            'year'      => 'nullable|integer',
            'file'      => 'nullable|mimes:pdf|max:10240',
            'is_active' => 'boolean',
        ]);
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('papers', 'public');
        }
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['file']);
        $paper->update($data);
        return redirect()->route('admin.papers.index')->with('success', 'Paper updated.');
    }

    public function destroy(Paper $paper)
    {
        $paper->delete();
        return back()->with('success', 'Deleted.');
    }
}