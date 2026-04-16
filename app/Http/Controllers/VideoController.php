<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos     = Video::where('is_active', true)->orderBy('sort_order')->get();
        $categories = $videos->pluck('category')->unique()->filter()->values();
        return view('pages.video.index', compact('videos', 'categories'));
    }
}