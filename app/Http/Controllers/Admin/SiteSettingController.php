<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $owner   = SiteSetting::where('group', 'owner')->get()->keyBy('key');
        $general = SiteSetting::where('group', 'general')->get()->keyBy('key');

        return view('admin.settings.index', compact('owner', 'general'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'owner_name'          => 'required|string|max:255',
            'owner_title'         => 'required|string|max:255',
            'owner_qualification' => 'nullable|string|max:500',
            'owner_phone'         => 'nullable|string|max:30',
            'owner_whatsapp'      => 'nullable|string|max:30',
            'owner_address'       => 'nullable|string|max:255',
            'owner_photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'site_name'           => 'required|string|max:255',
            'site_tagline'        => 'nullable|string|max:255',
            'site_email'          => 'nullable|email|max:255',
        ]);

        // Handle photo upload
        if ($request->hasFile('owner_photo')) {
            // Delete old photo if exists
            $oldPhoto = SiteSetting::get('owner_photo');
            if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            $path = $request->file('owner_photo')->store('settings', 'public');
            SiteSetting::set('owner_photo', $path);
        }

        // Save all other fields
        $fields = [
            'owner_name', 'owner_title', 'owner_qualification',
            'owner_phone', 'owner_whatsapp', 'owner_address',
            'site_name', 'site_tagline', 'site_email',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->input($field));
            }
        }

        SiteSetting::clearCache();

        return back()->with('success', 'Settings saved successfully!');
    }
}