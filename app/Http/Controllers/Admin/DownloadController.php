<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::orderBy('sort_order')->paginate(15);
        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:100',
            'file'        => 'required|max:10240',
            'is_active'   => 'boolean',
        ]);
        $data['file_path'] = $request->file('file')->store('downloads', 'public');
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['file']);
        Download::create($data);
        return redirect()->route('admin.downloads.index')->with('success', 'File uploaded.');
    }

    public function edit(Download $download)
    {
        return view('admin.downloads.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:100',
            'file'        => 'nullable|max:10240',
            'is_active'   => 'boolean',
        ]);
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('downloads', 'public');
        }
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['file']);
        $download->update($data);
        return redirect()->route('admin.downloads.index')->with('success', 'Updated.');
    }

    public function destroy(Download $download)
    {
        $download->delete();
        return back()->with('success', 'Deleted.');
    }
}