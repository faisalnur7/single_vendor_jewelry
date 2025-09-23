<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\Product;
use App\Models\HomePageSetting;
use Illuminate\Support\Facades\Cache;


class DashboardController extends Controller
{
    public function index(){
        $data['title'] = $data['page_title'] = "Dashboard";
        $data['products'] = Product::query()->with('variants')->where('parent_id',0)->get();
        $data['homepage_setting'] = HomePageSetting::first(); 
        return view('frontend.homepage', $data);
    }


    public function best_sellers(){
        $data['title'] = $data['page_title'] = "Collections";
        $data['products'] = Product::query()->with('variants')->where('parent_id',0)->get();
        return view('frontend.pages.plp', $data);
    }

    public function show_product(Product $product){
        $data['title'] = $data['page_title'] = "";
        $data['product_bold'] = true;
        $data['category'] = $product->category;
        $data['subcategory'] = $product->subCategory;
        $data['childsubcategory'] = $product->childSubCategory;
        $data['product'] = $product;

        if(empty($product->variants->first()) && !empty($product->parent)){
            $data['product'] = $product->parent;
        }
        return view('frontend.pages.pdp', $data);
    }

    public function product_list_page(Request $request)
    {
        return $this->product_list_handler($request, 'best_sellers', null);
    }

    public function show_categorywise(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return $this->product_list_handler($request, 'category', $category);
    }

    public function show_subcategorywise(Request $request, Category $category, Subcategory $subcategory)
    {
        return $this->product_list_handler($request, 'subcategory', $subcategory, $category);
    }

    public function show_child_subcategorywise(Request $request, Category $category, Subcategory $subcategory, ChildSubCategory $childsubcategory)
    {
        return $this->product_list_handler($request, 'childsubcategory', $childsubcategory, $category, $subcategory);
    }

    /**
     * Unified handler for product listing pages
     */
    protected function product_list_handler(Request $request, string $type, $model = null, $category = null, $subcategory = null)
    {
        $page = $request->get('page', 1);
        $sortBy = $request->get('sort_by');

        // Prepare cache key
        $cacheKey = match($type) {
            'best_sellers' => "best_sellers_page_{$page}_sort_{$sortBy}",
            'category' => "category_products_{$model->id}_page_{$page}_sort_{$sortBy}",
            'subcategory' => "subcategory_products_{$model->id}_page_{$page}_sort_{$sortBy}",
            'childsubcategory' => "childsubcategory_products_{$model->id}_page_{$page}_sort_{$sortBy}",
        };

        // Prepare filter params
        $filterParams = [];
        if ($type === 'category') $filterParams['category_id'] = $model->id;
        if ($type === 'subcategory') $filterParams['sub_category_id'] = $model->id;
        if ($type === 'childsubcategory') $filterParams['child_sub_category_id'] = $model->id;

        $products = Cache::remember(
            $cacheKey,
            60,
            fn() => $this->filter($request, $filterParams)
        );

        $products = $this->mapProducts($products);

        // Prepare view data
        $data = [
            'products' => $products,
            'title' => $data['page_title'] = $model->name ?? "Collection",
        ];

        // Bold flags for UI highlighting
        if ($type === 'category') {
            $data['category_bold'] = true;
            $data['category'] = $model;
        }
        if ($type === 'subcategory') {
            $data['subcategory_bold'] = true;
            $data['category'] = $category;
            $data['subcategory'] = $model;
        }
        if ($type === 'childsubcategory') {
            $data['childsubcategory_bold'] = true;
            $data['category'] = $category;
            $data['subcategory'] = $subcategory;
            $data['childsubcategory'] = $model;
        }

        return view('frontend.pages.plp', $data);
    }


    public function mapProducts($products){
        $products->map(function($product){
            $product->price_range = show_price_range($product->variants);
            return $product;
        });
        return $products;
    }

    protected function filter(Request $request, $extraConditions = [])
    {
        $query = Product::query()->with('variants')->where('parent_id', 0);

        // Apply extra conditions (category, subcategory, child subcategory etc.)
        foreach ($extraConditions as $field => $value) {
            $query->where($field, $value);
        }

        // Apply sorting
        switch ($request->get('sort_by')) {
            case 'price-ascending':
                $query->orderBy('price', 'asc');
                break;
            case 'price-descending':
                $query->orderBy('price', 'desc');
                break;
            case 'published-descending':
                $query->orderBy('created_at', 'desc');
                break;
            // case 'best-selling':
            //     $query->orderBy('total_sales', 'desc');
            //     break;
            // case 'add_to_cart_count':
            //     $query->orderBy('add_to_cart_count', 'desc');
            //     break;
            // case 'views':
            //     $query->orderBy('views', 'desc');
            //     break;
            default: // manual/featured
                $query->latest();
                break;
        }

        return $query->paginate(30);
    }
}
