<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Show All Categories
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Show Create Form
    public function create()
    {
        $categories = Category::all();  // Get all categories for the parent category dropdown
        return view('admin.categories.create', compact('categories'));
    }

    // Store New Category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name', 'slug');

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/category'), $filename);
            $data['image'] = 'uploads/category/' . $filename;
        }

        Category::create($data);
        return redirect()->route('category.list')->with('success', 'Category created successfully.');
    }

    // Show Edit Form
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all(); // To populate the parent category dropdown
        return view('admin.categories.edit', compact('category', 'categories'));
    }


    // Update Category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'slug' => 'required|unique:categories,slug,' . $category->id,
        ]);

        $data = $request->only('name', 'slug');
        
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/category'), $filename);
            $data['image'] = 'uploads/category/' . $filename;
        }

        $category->update($data);

        return redirect()->route('category.list')->with('success', 'Category updated successfully.');
    }

    // Delete Category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.list')->with('success', 'Category deleted successfully.');
    }
}
