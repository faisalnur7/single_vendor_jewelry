<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HomepageBanner;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Http\Request;

class HomepageBannerController extends Controller
{
    /**
     * Show all banners.
     */
    public function index()
    {
        $banners = HomepageBanner::with(['category', 'subCategory', 'childSubCategory'])->latest()->paginate(10);
        return view('admin.settings.homepage_banner.index', compact('banners'));
    }

    public function create()
    {
        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::all();
        $data['childSubCategories'] = ChildSubCategory::all();
        return view('admin.settings.homepage_banner.create', $data);
    }

    /**
     * Store a new banner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'child_sub_category_id' => 'nullable|exists:child_sub_categories,id',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|integer|in:0,1',
        ]);

        $data = $request->except('banner');

        if ($request->hasFile('banner')) {
            $filename = time() . '_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/banner'), $filename);
            $data['banner'] = 'uploads/banner/' . $filename;
        }

        $banner = HomepageBanner::create($data);

        return redirect()->route('homepage_banner.index');
    }

    /**
     * Edit banner (return JSON for AJAX modal).
     */
    public function edit($id)
    {
        $data['banner'] = HomepageBanner::find($id);
        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::all();
        $data['childSubCategories'] = ChildSubCategory::all();
        return view('admin.settings.homepage_banner.edit', $data);
    }

    /**
     * Update banner.
     */
    public function update(Request $request, HomepageBanner $homepageBanner)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'child_sub_category_id' => 'nullable|exists:child_sub_categories,id',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|integer|in:0,1',
        ]);

        $data = $request->except('banner');
        
        if ($request->hasFile('banner')) {
            $filename = time() . '_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/banner'), $filename);
            $data['banner'] = 'uploads/banner/' . $filename;
        }

        $homepageBanner->update($data);

        return redirect()->route('homepage_banner.index');
    }

    /**
     * Delete banner.
     */
    public function destroy($id)
    {
        $homepageBanner = HomepageBanner::find($id);
        $homepageBanner->delete();
        return redirect()->route('homepage_banner.index');
    }

    /**
     * Toggle banner status.
     */
    public function toggleStatus(HomepageBanner $homepageBanner)
    {
        $homepageBanner->status = $homepageBanner->status ? 0 : 1;
        $homepageBanner->save();

        return response()->json(['new_status' => $homepageBanner->status]);
    }

    public function getSubcategories($category_id)
    {
        $subCategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subCategories);
    }

    public function getChildSubcategories($sub_category_id)
    {
        $childSubCategories = ChildSubCategory::where('subcategory_id', $sub_category_id)->get();
        return response()->json($childSubCategories);
    }

}
