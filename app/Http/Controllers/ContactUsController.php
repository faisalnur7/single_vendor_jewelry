<?php

namespace App\Http\Controllers;
use App\Models\ContactSetting;
use App\Models\ContactUs;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function contact_us(){
        $data['contact_settings'] = ContactSetting::first();
        return view('frontend.pages.contact_us', $data);
    }

    public function contact_us_messages(Request $request){

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // ✅ Store message
        ContactUs::create($validated);

        // ✅ Redirect with success
        return response()->json(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
    }

}
