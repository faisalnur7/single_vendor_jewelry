<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function edit()
    {
        $setting = ContactSetting::firstOrCreate([]);
        return view('admin.settings.contact.create_', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'google_map_embed' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('settings/company_logo'), $filename);
            $data['company_logo'] = 'settings/company_logo/' . $filename;
        }

        ContactSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Contact & Company Info updated successfully.');
    }
}
