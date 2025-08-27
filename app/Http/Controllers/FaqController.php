<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function faq(){
        $data['faqs'] = Faq::query()->where('status','1')->get();
        return view('frontend.pages.faq', $data);
    }
    /**
     * Display all FAQs.
     */
    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Show form to create FAQ.
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Store new FAQ.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'status'   => 'nullable|boolean',
        ]);

        Faq::create($request->only(['question', 'answer', 'status']));

        return redirect()->route('faq.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Show form to edit FAQ.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update FAQ.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'status'   => 'nullable|boolean',
        ]);

        $faq->update($request->only(['question', 'answer', 'status']));

        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Delete FAQ.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faq.index')->with('success', 'FAQ deleted successfully.');
    }
}
