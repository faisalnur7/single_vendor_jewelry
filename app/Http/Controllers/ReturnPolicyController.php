<?php

namespace App\Http\Controllers;

use App\Models\ReturnPolicy;
use Illuminate\Http\Request;

class ReturnPolicyController extends Controller
{
    public function return_policy(){
        $data['return_policies'] = ReturnPolicy::query()->where('status','1')->get();
        return view('frontend.pages.return_policy', $data);
    }
    public function index()
    {
        $policies = ReturnPolicy::latest()->paginate(10);
        return view('admin.return_policy.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.return_policy.create_form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        ReturnPolicy::create($request->all());

        return redirect()->route('return_policy.index')->with('success', 'Return Policy added successfully.');
    }

    public function edit(ReturnPolicy $returnPolicy)
    {
        return view('admin.return_policy.edit_form', compact('returnPolicy'));
    }

    public function update(Request $request, ReturnPolicy $returnPolicy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        $returnPolicy->update($request->all());

        return redirect()->route('return_policy.index')->with('success', 'Return Policy updated successfully.');
    }

    public function destroy(ReturnPolicy $returnPolicy)
    {
        $returnPolicy->delete();
        return redirect()->back()->with('success', 'Return Policy deleted successfully.');
    }
}
