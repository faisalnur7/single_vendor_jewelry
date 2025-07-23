<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\Product;
use App\Models\HomePageSetting;

class DashboardController extends Controller
{
    public function index(){
        $data['title'] = $data['page_title'] = "Dashboard";
        $data['products'] = Product::query()->with('variants')->where('parent_id',0)->get();
        $data['homepage_setting'] = HomePageSetting::first(); 
        return view('frontend.homepage', $data);
    }

    public function product_list_page(){
        $data['title'] = $data['page_title'] = "Collections";
        $data['products'] = Product::query()->with('variants')->where('parent_id',0)->get();
        return view('frontend.pages.plp', $data);
    }

    public function show_categorywise($slug){
        $data['title'] = $data['page_title'] = "Collections";
        $data['category_bold'] = true;
        $data['category'] = $category = Category::query()->where('slug',$slug)->first();
        $data['products'] = Product::query()->with('variants')->where('category_id',$category->id)->where('parent_id',0)->get();
        return view('frontend.pages.plp', $data);
    }

    public function show_subcategorywise(Category $category, Subcategory $subcategory){
        $data['title'] = $data['page_title'] = "Collections";
        $data['subcategory_bold'] = true;
        $data['subcategory'] = $subcategory;
        $data['category'] = $category;
        $data['products'] = Product::query()->with('variants')->where('sub_category_id',$subcategory->id)->where('parent_id',0)->get();
        return view('frontend.pages.plp', $data);
    }

    public function show_child_subcategorywise(Category $category, Subcategory $subcategory, ChildSubCategory $childsubcategory){
        $data['title'] = $data['page_title'] = "Collections";
        $data['childsubcategory_bold'] = true;
        $data['childsubcategory'] = $childsubcategory;
        $data['subcategory'] = $subcategory;
        $data['category'] = $category;
        $data['products'] = Product::query()->with('variants')->where('child_sub_category_id',$childsubcategory->id)->where('parent_id',0)->get();
        return view('frontend.pages.plp', $data);
    }

    public function show_product(Product $product){
        $data['title'] = $data['page_title'] = "";
        $data['product_bold'] = true;
        $data['category'] = $product->category;
        $data['subcategory'] = $product->subCategory;
        $data['childsubcategory'] = $product->childSubCategory;
        $data['product'] = $product;
        return view('frontend.pages.pdp', $data);
    }
}
