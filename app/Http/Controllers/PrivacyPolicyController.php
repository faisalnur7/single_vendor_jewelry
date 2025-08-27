<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function privacy_policy(){
        $data['privacy_policies'] = PrivacyPolicy::query()->where('status','1')->get();
        return view('frontend.pages.privacy_policy', $data);
    }

    public function index()
    {
        $policies = PrivacyPolicy::latest()->paginate(10);
        return view('admin.privacy_policy.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.privacy_policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        PrivacyPolicy::create($request->all());

        return redirect()->route('privacy_policy.index')->with('success', 'Privacy Policy added successfully.');
    }

    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.privacy_policy.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        $privacyPolicy->update($request->all());

        return redirect()->route('privacy_policy.index')->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();
        return redirect()->back()->with('success', 'Privacy Policy deleted successfully.');
    }
}
