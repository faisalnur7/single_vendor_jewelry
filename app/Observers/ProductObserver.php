<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product)
    {
        $this->clearCache($product);
    }

    public function deleted(Product $product)
    {
        $this->clearCache($product);
    }

    protected function clearCache(Product $product)
    {
        $perPage = 30; // same as your paginate(30)

        // Clear Best Sellers pagination cache
        $bestSellerCount = Product::where('parent_id', 0)->count();
        $bestSellerPages = ceil($bestSellerCount / $perPage);

        for ($page = 1; $page <= $bestSellerPages; $page++) {
            Cache::forget("best_sellers_page_{$page}");
        }

        // Clear Category cache if product has category
        if ($product->category_id) {
            $categoryCount = Product::where('category_id', $product->category_id)
                ->where('parent_id', 0)->count();
            $categoryPages = ceil($categoryCount / $perPage);

            for ($page = 1; $page <= $categoryPages; $page++) {
                Cache::forget("category_products_{$product->category_id}_page_{$page}");
            }
        }

        // Clear Subcategory cache
        if ($product->sub_category_id) {
            $subCategoryCount = Product::where('sub_category_id', $product->sub_category_id)
                ->where('parent_id', 0)->count();
            $subCategoryPages = ceil($subCategoryCount / $perPage);

            for ($page = 1; $page <= $subCategoryPages; $page++) {
                Cache::forget("subcategory_products_{$product->sub_category_id}_page_{$page}");
            }
        }

        // Clear Child Subcategory cache
        if ($product->child_sub_category_id) {
            $childSubCategoryCount = Product::where('child_sub_category_id', $product->child_sub_category_id)
                ->where('parent_id', 0)->count();
            $childSubCategoryPages = ceil($childSubCategoryCount / $perPage);

            for ($page = 1; $page <= $childSubCategoryPages; $page++) {
                Cache::forget("childsubcategory_products_{$product->child_sub_category_id}_page_{$page}");
            }
        }
    }
}
