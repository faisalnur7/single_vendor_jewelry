<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMediaSetting;

class SocialMediaSettingController extends Controller
{
    public function edit()
    {
        $setting = SocialMediaSetting::firstOrCreate([]);
        return view('admin.settings.social.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $setting = SocialMediaSetting::first();

        if ($request->hasFile('logo')) {
            $filename = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('settings/social'), $filename);
            $validated['logo'] = 'settings/social/' . $filename;
        }

        $setting->update($validated);

        return back()->with('success', 'Social media links updated successfully.');
    }
}
