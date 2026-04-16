<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::where('is_active', true)
            ->with('images')
            ->orderBy('sort_order')
            ->get();

        return view('pages.gallery.index', compact('albums'));
    }

    public function show(GalleryAlbum $album)
    {
        abort_if(!$album->is_active, 404);
        $album->load('images');
        return view('pages.gallery.show', compact('album'));
    }
}