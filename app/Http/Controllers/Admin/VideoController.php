<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('sort_order')->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'video_url'   => 'required|string',
            'source'      => 'required|in:youtube,facebook,upload',
            'category'    => 'nullable|string|max:100',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Video::create($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video added.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'video_url'   => 'required|string',
            'source'      => 'required|in:youtube,facebook,upload',
            'category'    => 'nullable|string|max:100',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $video->update($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video updated.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return back()->with('success', 'Video deleted.');
    }
}