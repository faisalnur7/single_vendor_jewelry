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
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/shipping_logos'), $filename);
            $data['logo'] = 'uploads/shipping_logos/' . $filename;
        }

        $data['status'] = true;

        $shippingMethod = ShippingMethod::create($data);

        return response()->json(['status' => 'success', 'shipping' => $shippingMethod]);
    }

    public function edit(ShippingMethod $shippingMethod){
        return response()->json($shippingMethod);
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
            // Delete old logo if exists
            if ($shippingMethod->logo && file_exists(public_path($shippingMethod->logo))) {
                unlink(public_path($shippingMethod->logo));
            }

            // Move uploaded file manually
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/shipping_logos'), $filename);
            $data['logo'] = 'uploads/shipping_logos/' . $filename;
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
