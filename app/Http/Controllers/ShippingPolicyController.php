<?php

namespace App\Http\Controllers;

use App\Models\ShippingPolicy;
use Illuminate\Http\Request;

class ShippingPolicyController extends Controller
{
    public function shipping_policy(){
        $data['shipping_policies'] = ShippingPolicy::query()->where('status','1')->get();
        return view('frontend.pages.shipping_policy', $data);
    }

    public function index()
    {
        $policies = ShippingPolicy::latest()->paginate(10);
        return view('admin.shipping_policy.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.shipping_policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        ShippingPolicy::create($request->all());

        return redirect()->route('shipping_policy.index')->with('success', 'Shipping Policy added successfully.');
    }

    public function edit(ShippingPolicy $shippingPolicy)
    {
        return view('admin.shipping_policy.edit', compact('shippingPolicy'));
    }

    public function update(Request $request, ShippingPolicy $shippingPolicy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        $shippingPolicy->update($request->all());

        return redirect()->route('shipping_policy.index')->with('success', 'Shipping Policy updated successfully.');
    }

    public function destroy(ShippingPolicy $shippingPolicy)
    {
        $shippingPolicy->delete();
        return redirect()->back()->with('success', 'Shipping Policy deleted successfully.');
    }
}
