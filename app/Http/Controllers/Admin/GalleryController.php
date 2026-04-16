<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('images')->orderBy('sort_order')->paginate(15);
        return view('admin.gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
            'images.*'    => 'image|max:4096',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $album = GalleryAlbum::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('gallery', 'public');
                GalleryImage::create(['album_id' => $album->id, 'image_path' => $path, 'sort_order' => $i]);
                if ($i === 0) $album->update(['cover_image' => $path]);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Album created.');
    }

    public function edit(GalleryAlbum $gallery)
    {
        $gallery->load('images');
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryAlbum $gallery)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
            'images.*'    => 'image|max:4096',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $gallery->update($data);

        if ($request->hasFile('images')) {
            $count = $gallery->images()->count();
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('gallery', 'public');
                GalleryImage::create(['album_id' => $gallery->id, 'image_path' => $path, 'sort_order' => $count + $i]);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Album updated.');
    }

    public function destroy(GalleryAlbum $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Album deleted.');
    }
}