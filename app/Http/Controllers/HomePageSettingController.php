<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePageSetting;

class HomePageSettingController extends Controller
{
    public function edit()
    {
        $setting = HomePageSetting::firstOrCreate([]);
        return view('admin.settings.homepage.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'why_choose_us' => 'nullable|string',
            'about' => 'nullable|string',
            'down_paragraph' => 'nullable|string',
        ]);

        $setting = HomePageSetting::first();
        $setting->update($validated);

        return back()->with('success', 'Home page content updated successfully.');
    }
}
