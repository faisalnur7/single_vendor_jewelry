<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->shippingAddresses()->latest()->get();
        return view('frontend.user.shipping.index', compact('addresses'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('frontend.user.shipping.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        if(!empty($data['is_default'])){
            Auth::user()->shippingAddresses()->update(['is_default' => 0]);
        }

        $data['country_id'] = $request->country;
        $data['state_id'] = $request->state;
        $data['city_id'] = $request->city;

        Auth::user()->shippingAddresses()->create($data);

        return redirect()->route('user_shipping_index')->with('success', 'Address added successfully.');
    }

    public function edit($id)
    {
        $countries = Country::all();
        $shippingAddress = ShippingAddress::query()->findOrFail($id);
        // $this->authorize('update', $shippingAddress);
        return view('frontend.user.shipping.edit', compact('shippingAddress','countries'));
    }

    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        // $this->authorize('update', $shippingAddress);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        if(!empty($data['is_default'])){
            Auth::user()->shippingAddresses()->update(['is_default' => false]);
        }

        $shippingAddress->update($data);

        return redirect()->route('user_shipping_index')->with('success', 'Address updated successfully.');
    }

    public function destroy(ShippingAddress $shippingAddress)
    {
        // $this->authorize('delete', $shippingAddress);
        $shippingAddress->delete();
        return redirect()->route('user_shipping_index')->with('success', 'Address deleted successfully.');
    }
}
