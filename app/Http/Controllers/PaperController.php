<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Download;

class PaperController extends Controller
{
    public function papers()
    {
        $papers  = Paper::where('is_active', true)->orderBy('sort_order')->get();
        $grades  = $papers->pluck('grade')->unique()->filter()->values();
        $subjects= $papers->pluck('subject')->unique()->filter()->values();
        return view('pages.paper.index', compact('papers', 'grades', 'subjects'));
    }

    public function downloads()
    {
        $downloads  = Download::where('is_active', true)->orderBy('sort_order')->get();
        $categories = $downloads->pluck('category')->unique()->filter()->values();
        return view('pages.download.index', compact('downloads', 'categories'));
    }
}