<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'subCategory', 'childsubcategory']) // Eager load relations
            ->when($request->has('view_options') && $request->view_options != '', function ($query) use ($request) {
                if($request->view_options == Product::VARIANTS_ONLY){
                    return $query->where('parent_id','!=','0');
                }else if($request->view_options == Product::MAIN_PRODUCT_ONLY){
                    return $query->where('parent_id','0');
                }else if($request->view_options == Product::BOTH){
                    return $query;
                }else{
                    return $query->where('parent_id','0');
                }
            })
            ->when(!$request->has('view_options'), function ($query) use ($request) {
                    return $query->where('parent_id','0');
            })
            // Filtering SKU
            ->when($request->has('sku') && $request->sku != '', function ($query) use ($request) {
                return $query->where('sku', 'like', '%' . $request->sku . '%');
            })
            // Filtering Product Name
            ->when($request->has('name') && $request->name != '', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->name . '%');
            })
            // Filtering Price Range
            ->when($request->has('price_min') && $request->price_min != '', function ($query) use ($request) {
                return $query->where('price', '>=', $request->price_min);
            })
            ->when($request->has('price_max') && $request->price_max != '', function ($query) use ($request) {
                return $query->where('price', '<=', $request->price_max);
            })
            // Filtering by Category
            ->when($request->has('category') && $request->category != '', function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            // Filtering by Sub Category
            ->when($request->has('sub_category') && $request->sub_category != '', function ($query) use ($request) {
                return $query->where('sub_category_id', $request->sub_category);
            })
            // Filtering by Child Sub Category
            ->when($request->has('child_sub_category') && $request->child_sub_category != '', function ($query) use ($request) {
                return $query->where('child_sub_category_id', $request->child_sub_category);
            })
            // Paginate the results
            ->paginate(10)
            ->appends($request->all());

        // Get all categories, subcategories, and brands for filter dropdowns
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $childSubCategories = ChildSubCategory::all();


        // Return the view with the filtered products and filter options
        return view('admin.products.index', compact('products', 'categories', 'subCategories','childSubCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $childsubcategories = ChildSubCategory::all();
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('categories', 'subcategories','childsubcategories','suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|unique:products,slug',
            //'price' => 'required|numeric',
            'image' => 'nullable|image',
            'gallery_images.*' => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();

            // Slug auto-generate if not provided
            $data['slug'] = $request->slug ?: Str::slug($request->name) . '-' . uniqid();

            // SKU base
            $data['sku'] = $request->category_id . ($request->sub_category_id ?? '0');

            // Image Upload
            if ($request->hasFile('image')) {
                $filename = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads/products'), $filename);
                $data['image'] = 'uploads/products/' . $filename;
            }

            // Gallery Images Upload
            if ($request->hasFile('gallery_images')) {
                $gallery = [];
                foreach ($request->file('gallery_images') as $image) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/products/gallery'), $filename);
                    $gallery[] = 'uploads/products/gallery/' . $filename;
                }
                $data['gallery_images'] = json_encode($gallery);
            }

            // Create Product
            $product = Product::create($data);
            // Get 1-letter category initial
            $categoryInitial = '';
            if ($product->category) {
                $categoryInitial = strtoupper(Str::substr($product->category->name, 0, 1));
            }

            // Get up to 2-letter subcategory initials (skip single-character words like &)
            $subCategoryInitials = '';
            if ($product->subCategory) {
                $words = explode(' ', $product->subCategory->name);

                // Filter out single-character words (like &, -, @, etc.)
                $filteredWords = array_filter($words, function ($word) {
                    return strlen($word) > 1;
                });

                $filteredWords = array_values($filteredWords); // reindex

                if (count($filteredWords) > 1) {
                    // Take first letter of first 2 valid words
                    $subCategoryInitials = strtoupper(
                        Str::substr($filteredWords[0], 0, 1) . Str::substr($filteredWords[1], 0, 1)
                    );
                } elseif (count($filteredWords) === 1) {
                    // Single valid word → take first 2 letters
                    $subCategoryInitials = strtoupper(Str::substr($filteredWords[0], 0, 2));
                }
            }

            $product->sku = $categoryInitial
                . $subCategoryInitials
                . $product->category_id 
                . ($product->sub_category_id ?? '0')
                . ($product->child_sub_category_id ?? '0')
                . $product->id;

            $product->save();

            // Variants
            if ($request->has_variants) {
                foreach ($request->variants as $key => $variant) {
                    $vData = $data; // copy main product data
                    $vData['slug'] = $product->slug . '-' . ($key + 1);
                    $vData['sku'] = $product->sku . '.' . ($key + 1);

                    $vProduct = Product::create($vData);
                    $vProduct->name = $product->name . '-' . ($key + 1);
                    $vProduct->color = $variant['color'] ?? null;
                    $vProduct->weight = $variant['weight'] ?? null;
                    $vProduct->gender = $data['gender'] ?? null;
                    $vProduct->price = $variant['price'] ?? null;
                    $vProduct->price_rmb = $variant['price_rmb'] ?? null;
                    $vProduct->purchase_price = $variant['purchase_price'] ?? null;
                    $vProduct->purchase_price_rmb = $variant['purchase_price_rmb'] ?? null;
                    $vProduct->description = $variant['description'] ?? null;
                    $vProduct->parent_id = $product->id;
                    $vProduct->sku = $product->sku . ($key + 1);
                    $vProduct->has_variants = 0;

                    // Variant image
                    if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $filename = time() . '_' . $variant['image']->getClientOriginalName();
                        $variant['image']->move(public_path('uploads/products'), $filename);
                        $vProduct->image = 'uploads/products/' . $filename;
                    }

                    $vProduct->save();
                }
            }

            DB::commit();

            return redirect()->route('product.list')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Optionally delete uploaded files to avoid orphaned files
            if (isset($filename) && file_exists(public_path($filename))) {
                @unlink(public_path($filename));
            }

            if (isset($gallery)) {
                foreach ($gallery as $gFile) {
                    if (file_exists(public_path($gFile))) {
                        @unlink(public_path($gFile));
                    }
                }
            }

            return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    

    public function edit($id)
    {
        $product = Product::with(['category', 'subCategory'])->findOrFail($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $childsubcategories = ChildSubCategory::all();
        $suppliers = Supplier::all();
    
        return view('admin.products.edit', compact(
            'product',
            'categories',
            'subcategories',
            'childsubcategories',
            'suppliers'
        ));
    }
    

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|unique:products,slug,' . $product->id,
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        // Slug generation
        $data['slug'] = $request->slug ?: Str::slug($request->name) . '-' . uniqid();

        // ✅ Regenerate SKU if category/subcategory changed
        if ($request->category_id != $product->category_id || $request->sub_category_id != $product->sub_category_id) {
            $category = Category::find($request->category_id);
            $subCategory = SubCategory::find($request->sub_category_id);

            // Category → 1 letter
            $categoryInitial = $category ? strtoupper(Str::substr($category->name, 0, 1)) : '';

            // Subcategory → max 2 letters, skip & and symbols
            $subCategoryInitials = '';
            if ($subCategory) {
                $words = explode(' ', $subCategory->name);

                // filter out single-char words like "&"
                $filteredWords = array_filter($words, fn($w) => strlen($w) > 1);
                $filteredWords = array_values($filteredWords);

                if (count($filteredWords) > 1) {
                    $subCategoryInitials = strtoupper(
                        Str::substr($filteredWords[0], 0, 1) .
                        Str::substr($filteredWords[1], 0, 1)
                    );
                } elseif (count($filteredWords) === 1) {
                    $subCategoryInitials = strtoupper(Str::substr($filteredWords[0], 0, 2));
                }
            }

            $data['sku'] = $categoryInitial
                . $subCategoryInitials
                . $request->category_id
                . ($request->sub_category_id ?? '0')
                . ($request->child_sub_category_id ?? '0')
                . $product->id;
        } else {
            // keep old SKU if category/subcategory not changed
            $data['sku'] = $product->sku;
        }

        // ✅ Replace Cover Image
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        // ✅ Update Product
        $product->update($data);

        // ✅ Variant handling (unchanged except SKU assignment fix)
        if ($request->has_variants) {
            foreach ($request->variants as $key => $variant) {
                if (!empty($variant['id'])) {
                    $vProduct = Product::findOrFail($variant['id']);
                    $vProduct->color = $variant['color'];
                    $vProduct->weight = $variant['weight'];
                    $vProduct->gender = $data['gender'];
                    $vProduct->price = $variant['price'];
                    $vProduct->price_rmb = $variant['price_rmb'];
                    $vProduct->purchase_price = $variant['purchase_price'];
                    $vProduct->purchase_price_rmb = $variant['purchase_price_rmb'];
                    $vProduct->description = $variant['description'] ?? '';

                    if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $filename = time() . '_' . $variant['image']->getClientOriginalName();
                        $variant['image']->move(public_path('uploads/products'), $filename);
                        $vProduct->image = 'uploads/products/' . $filename;
                    }

                    $vProduct->save();
                } else {
                    $data['slug'] = $product->slug . '-' . ($key + 1);
                    $data['sku'] = $product->sku . '.' . ($key + 1);

                    $vProduct = Product::create($data);
                    $vProduct->name = $product->name . '-' . ($key + 1);
                    $vProduct->color = $variant['color'];
                    $vProduct->weight = $variant['weight'];
                    $vProduct->gender = $data['gender'];
                    $vProduct->price = $variant['price'];
                    $vProduct->price_rmb = $variant['price_rmb'];
                    $vProduct->purchase_price = $variant['purchase_price'];
                    $vProduct->purchase_price_rmb = $variant['purchase_price_rmb'];
                    $vProduct->description = $variant['description'] ?? '';
                    $vProduct->parent_id = $product->id;
                    $vProduct->sku = $product->sku . ($key + 1);
                    $vProduct->has_variants = 0;

                    if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $filename = time() . '_' . $variant['image']->getClientOriginalName();
                        $variant['image']->move(public_path('uploads/products'), $filename);
                        $vProduct->image = 'uploads/products/' . $filename;
                    }

                    $vProduct->save();
                }
            }
        }

        return redirect()->route('product.list')->with('success', 'Product updated successfully.');
    }

    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
    
        // Delete main image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
    
        // Delete gallery images
        if ($product->gallery_images) {
            foreach (json_decode($product->gallery_images) as $img) {
                if (file_exists(public_path($img))) {
                    unlink(public_path($img));
                }
            }
        }
    
        // Delete the product
        $product->delete();
    
        return redirect()->route('product.list')->with('success', 'Product deleted successfully.');
    }

    public function getProducts(Request $request)
    {
        $query = Product::query()
            ->where('has_variants', '0')
            ->with(['purchaseItems', 'orderItems']); // eager load for performance

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->filled('child_sub_category_id')) {
            $query->where('child_sub_category_id', $request->child_sub_category_id);
        }

        $products = $query->get();

        // Format response with current_stock
        $productsFormatted = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'color' => $product->color,
                'weight' => $product->weight,
                'price' => $product->price,
                'affiliate_price' => $product->affiliate_price,
                'purchase_price' => $product->purchase_price,
                'category_id' => $product->category_id,
                'sub_category_id' => $product->sub_category_id,
                'child_sub_category_id' => $product->child_sub_category_id,
                'brand_id' => $product->brand_id,
                'image' => $product->image,
                'current_stock' => $product->current_stock,
            ];
        });

        return response()->json([
            'products' => $productsFormatted
        ]);
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function getNextProductId(){
        $lastId = Product::max('id') ?? 0;
        $nextId = $lastId + 1;
        return response()->json(['product_id' => $nextId]);
    }

    public function stock(Request $request){
        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::all();
        $data['childSubCategories'] = ChildSubCategory::all();
        
        $data['products'] = Product::with(['category', 'subCategory', 'childsubcategory','purchaseItems', 'orderItems'])
            ->where('has_variants','0')
            // Filtering SKU
            ->when($request->has('sku') && $request->sku != '', function ($query) use ($request) {
                return $query->where('sku', 'like', '%' . $request->sku . '%');
            })
            // Filtering Product Name
            ->when($request->has('name') && $request->name != '', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->name . '%');
            })
            // Filtering Price Range
            ->when($request->has('price_min') && $request->price_min != '', function ($query) use ($request) {
                return $query->where('price', '>=', $request->price_min);
            })
            ->when($request->has('price_max') && $request->price_max != '', function ($query) use ($request) {
                return $query->where('price', '<=', $request->price_max);
            })
            // Filtering by Category
            ->when($request->has('category') && $request->category != '', function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            // Filtering by Sub Category
            ->when($request->has('sub_category') && $request->sub_category != '', function ($query) use ($request) {
                return $query->where('sub_category_id', $request->sub_category);
            })
            // Filtering by Child Sub Category
            ->when($request->has('child_sub_category') && $request->child_sub_category != '', function ($query) use ($request) {
                return $query->where('child_sub_category_id', $request->child_sub_category);
            })
            // Paginate the results
            ->paginate(10)
            ->appends($request->all());
        return view('admin.products.stock', $data);   
    }

    public function ajaxSearchProducts(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::where('parent_id','0')
                    ->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('sku',$keyword)
                    ->take(5)
                    ->get(['name','slug','image']);

        return response()->json(['products' => $products]);
    }

    public function searchPage(Request $request)
    {
        $keyword = $request->keyword;

        $query = Product::where('parent_id','0')
                    ->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('sku',$keyword);

        $products = $query->paginate(20);

        $product_count = $query->count();

        return view('frontend.pages.search_results', compact('products', 'keyword','product_count'));
    }

}
