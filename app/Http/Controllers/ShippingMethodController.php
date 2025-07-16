<?php

namespace App\Http\Controllers;

use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShippingMethodController extends Controller
{
    public function index()
    {
        return view('admin.shipping_methods.index', [
            'shippingMethods' => ShippingMethod::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'cost' => 'required|numeric',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('shipping_logos', 'public');
        }

        $data['status'] = true;

        $shippingMethod = ShippingMethod::create($data);

        return response()->json(['status' => 'success', 'shipping' => $shippingMethod]);
    }

    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'cost' => 'required|numeric',
            'status' => 'required|boolean',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($shippingMethod->logo) {
                Storage::disk('public')->delete($shippingMethod->logo);
            }
            $data['logo'] = $request->file('logo')->store('shipping_logos', 'public');
        }

        $shippingMethod->update($data);

        return response()->json(['status' => 'success']);
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        if ($shippingMethod->logo) {
            Storage::disk('public')->delete($shippingMethod->logo);
        }

        $shippingMethod->delete();
        return response()->json(['status' => 'deleted']);
    }

    public function toggleStatus(ShippingMethod $shippingMethod)
    {
        $shippingMethod->status = !$shippingMethod->status;
        $shippingMethod->save();

        return response()->json(['status' => 'toggled', 'new_status' => $shippingMethod->status]);
    }
}
