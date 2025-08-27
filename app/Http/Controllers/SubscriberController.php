<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
     // Show all subscribers
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(10);
        return view('admin.subscribers.list', compact('subscribers'));
    }

    // Show form to create subscriber
    public function create()
    {
        return view('subscribers.create');
    }

    // Store subscriber
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create($request->only('email'));

        // Return JSON response for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Subscribed successfully!'
        ]);
    }


    // Show form to edit subscriber
    public function edit(Subscriber $subscriber)
    {
        return view('subscribers.edit', compact('subscriber'));
    }

    // Update subscriber
    public function update(Request $request, Subscriber $subscriber)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email,' . $subscriber->id,
        ]);

        $subscriber->update($request->only('email'));
        return redirect()->route('subscribers')->with('success', 'Subscriber updated successfully.');
    }

    // Delete subscriber
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        return redirect()->route('subscribers')->with('success', 'Subscriber deleted successfully.');
    }
}
