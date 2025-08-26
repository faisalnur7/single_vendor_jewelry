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
        // Validate input
        $request->validate([
            'name' => 'required|unique:categories,name',
            'slug' => 'nullable|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Collect data except image
        $data = $request->except('image');

        // Auto-generate slug if not provided
        $data['slug'] = $request->slug ?? \Str::slug($request->name);

        // Handle checkboxes (default 0)
        $data['is_trending'] = $request->has('is_trending') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['show_on_main_menu'] = $request->has('show_on_main_menu') ? 1 : 0;


        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/category'), $filename);
            $data['image'] = 'uploads/category/' . $filename;
        }

        // Create new category
        Category::create($data);

        return redirect()
            ->route('category.list')
            ->with('success', 'Category created successfully.');
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

        // Validation
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Collect data
        $data = $request->except('image');

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/category'), $filename);
            $data['image'] = 'uploads/category/' . $filename;
        }

        // Handle checkboxes (default 0 if not checked)
        $data['is_trending'] = $request->has('is_trending') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['show_on_main_menu'] = $request->has('show_on_main_menu') ? 1 : 0;


        // Update category
        $category->update($data);

        return redirect()
            ->route('category.list')
            ->with('success', 'Category updated successfully.');
    }


    // Delete Category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.list')->with('success', 'Category deleted successfully.');
    }
}
