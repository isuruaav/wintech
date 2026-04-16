<?php

namespace App\Http\Controllers;

use App\Models\OnlineClass;

class OnlineClassController extends Controller
{
    public function index()
    {
        $live     = OnlineClass::where('is_active', true)
            ->where('scheduled_at', '<=', now())
            ->where('scheduled_at', '>=', now()->subHours(3))
            ->orderBy('scheduled_at')->get();

        $upcoming = OnlineClass::where('is_active', true)
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')->get();

        $past     = OnlineClass::where('is_active', true)
            ->where('scheduled_at', '<', now()->subHours(3))
            ->orderByDesc('scheduled_at')->take(10)->get();

        return view('pages.online-class.index', compact('live', 'upcoming', 'past'));
    }
}