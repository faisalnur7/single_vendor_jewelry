<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CacheSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheSettingController extends Controller
{
    public function edit()
    {
        $setting = CacheSetting::first();
        return view('admin.cache_settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = CacheSetting::first();
        $setting->update(['is_enabled' => $request->has('is_enabled')]);

        // Clear cache when turned off
        if (! $setting->is_enabled) {
            Cache::flush();
        }

        return back()->with('success', 'Cache setting updated.');
    }
}
