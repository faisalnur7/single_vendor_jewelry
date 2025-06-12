<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(){
        $data['title'] = $data['page_title'] = "Dashboard";
        $data['products'] = Product::query()->with('variants')->where('parent_id',0)->get();
        return view('frontend.homepage', $data);
    }

    public function product_list_page(){
        $data['title'] = $data['page_title'] = "Collections";
        $data['products'] = Product::query()->with('variants')->where('parent_id',0)->get();
        return view('frontend.pages.plp', $data);
    }

    public function show_categorywise($slug){
        $data['title'] = $data['page_title'] = "Collections";
        return view('frontend.pages.plp', $data);
    }

    public function show_subcategorywise($slug){
        $data['title'] = $data['page_title'] = "Collections";
        return view('frontend.pages.plp', $data);
    }

    public function show_product($slug){
        $data['title'] = $data['page_title'] = "Collections";
        return view('frontend.pages.plp', $data);
    }
}
