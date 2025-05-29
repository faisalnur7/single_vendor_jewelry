<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Http\Request;

class ChildSubCategoryController extends Controller
{
    public function index()
    {
        $childsubcategories = ChildSubCategory::with(['category', 'subcategory'])->get();
        return view('admin.childsubcategories.index', compact('childsubcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.childsubcategories.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:child_sub_categories,slug',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name', 'slug', 'category_id', 'subcategory_id');

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/childsubcategory'), $filename);
            $data['image'] = 'uploads/childsubcategory/' . $filename;
        }

        ChildSubCategory::create($data);

        return redirect()->route('childsubcategory.list')->with('success', 'Child SubCategory created successfully.');
    }


    public function edit($id)
    {
        $childsubcategory = ChildSubCategory::findOrFail($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.childsubcategories.edit', compact('childsubcategory', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $childsubcategory = ChildSubCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:child_sub_categories,slug,' . $id,
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name', 'slug', 'category_id', 'subcategory_id');

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/childsubcategory'), $filename);
            $data['image'] = 'uploads/childsubcategory/' . $filename;
        }

        $childsubcategory->update($data);

        return redirect()->route('childsubcategory.list')->with('success', 'Child SubCategory updated successfully.');
    }


    public function destroy($id)
    {
        $childsubcategory = ChildSubCategory::findOrFail($id);
        $childsubcategory->delete();

        return redirect()->route('childsubcategory.list')->with('success', 'Child SubCategory deleted successfully.');
    }
}