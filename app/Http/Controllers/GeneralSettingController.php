<?php

// app/Http/Controllers/Admin/GeneralSettingController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    public function edit()
    {
        $settings = GeneralSetting::first();
        return view('admin.settings.general.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_title' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'site_favicon' => 'nullable|image|mimes:png,ico',
        ]);

        $data = $validated;

        // Store site_logo
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('settings/site_logo'), $logoName);
            $data['site_logo'] = 'settings/site_logo/' . $logoName;
        }

        // Store site_favicon
        if ($request->hasFile('site_favicon')) {
            $favicon = $request->file('site_favicon');
            $faviconName = time() . '_' . $favicon->getClientOriginalName();
            $favicon->move(public_path('settings/site_favicon'), $faviconName);
            $data['site_favicon'] = 'settings/site_favicon/' . $faviconName;
        }

        // Update or create the first row (id = 1 or blank condition)
        GeneralSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'General settings updated successfully.');
    }

}
