<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\CustomCategory;
use Illuminate\Http\Request;

class CustomCategoryController extends Controller
{
    public function index()
    {
        $customCategories = CustomCategory::with(['category', 'subcategory', 'childsubcategory'])->get();
        return view('admin.custom_categories.list', compact('customCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $childSubCategories = ChildSubCategory::all();
        return view('admin.custom_categories.create_', compact('categories', 'subCategories', 'childSubCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'slug'                  => 'required|string|max:255|unique:custom_categories,slug',
            'category_id'           => 'nullable|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:sub_categories,id',
            'child_sub_category_id' => 'nullable|exists:child_sub_categories,id',
            'type'                  => 'required|string|max:50', // 👈 added type
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order'                 => 'nullable|integer',
        ]);


        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/customcategory'), $filename);
            $data['image'] = 'uploads/customcategory/' . $filename;
        }

        CustomCategory::create($data);

        return redirect()->route('custom-category.list')->with('success', 'Custom Category created successfully.');
    }

    public function edit($id)
{
    $customCategory    = CustomCategory::findOrFail($id);
    $categories        = Category::where('show_on_main_menu', 1)->get();
    $subCategories     = SubCategory::all();
    $childSubCategories = ChildSubCategory::all();

    return view('admin.custom_categories.edit', compact(
        'customCategory',
        'categories',
        'subCategories',
        'childSubCategories'
    ));
}


    public function update(Request $request, $id)
    {
        $customcategory = CustomCategory::findOrFail($id);

        $request->validate([
            'name'                  => 'required|string|max:255',
            'slug'                  => 'required|string|max:255|unique:custom_categories,slug,' . $id,
            'category_id'           => 'nullable|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:sub_categories,id',
            'child_sub_category_id' => 'nullable|exists:child_sub_categories,id',
            'type'                  => 'required|string|max:50', // 👈 added type
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order'                 => 'nullable|integer',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/customcategory'), $filename);
            $data['image'] = 'uploads/customcategory/' . $filename;
        }

        $customcategory->update($data);

        return redirect()->route('custom-category.list')->with('success', 'Custom Category updated successfully.');
    }

    public function destroy($id)
    {
        $customcategory = CustomCategory::findOrFail($id);
        $customcategory->delete();

        return redirect()->route('custom-category.list')->with('success', 'Custom Category deleted successfully.');
    }
}
