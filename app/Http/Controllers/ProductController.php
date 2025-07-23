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

        $data = $request->all();
    
        // Slug auto-generate if not provided
        $data['slug'] = $request->slug ?: Str::slug($request->name) . '-' . uniqid();

        $data['sku'] = $request->category_id 
              . ($request->sub_category_id ?? '0') 
              . ($request->brand_id ?? '0');
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
    
        // Create Product First
        $product = Product::create($data);

        $product->sku = $product->category_id 
              . ($product->sub_category_id ?? '0') 
              . ($product->brand_id ?? '0') 
              . '.' 
              . $product->id;

        $product->save();
        if($request->has_variants){
            foreach ($request->variants as $key => $variant) {
                $data['slug'] = $product->slug . '-' . ($key + 1);
                $data['sku'] = $product->sku . '.' . ($key + 1);

                $vProduct = Product::create($data);
                $vProduct->name = $product->name.'-'.($key+1);
                $vProduct->color = $variant['color'];
                $vProduct->price = $variant['price'];
                $vProduct->purchase_price = $variant['purchase_price'];
                $vProduct->stock = $variant['stock'];
                $vProduct->description = $variant['description'];
                $vProduct->stock = $variant['stock'];
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

    
        // Attach Sale Logs (if any selected)
    
        return redirect()->route('product.list')->with('success', 'Product created successfully.');
    }
    

    public function edit($id)
    {
        $product = Product::with(['category', 'subCategory'])->findOrFail($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $childsubcategories = ChildSubCategory::all();
    
        return view('admin.products.edit', compact(
            'product',
            'categories',
            'subcategories',
            'childsubcategories'
        ));
    }
    

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|unique:products,slug,' . $product->id,
            // 'sku' => 'required|unique:products,sku,' . $product->id,
            //'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();
    
        $data['slug'] = $request->slug ?: Str::slug($request->name) . '-' . uniqid();
        $data['sku'] = $product->sku;

        // Replace Cover Image
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }
        // Update Product
        $product->update($data);

        if($request->has_variants){
            foreach ($request->variants as $key => $variant) {

                if(!empty($variant['id'])){
                    $vProduct = Product::query()->findOrFail($variant['id']);
                    $vProduct->color = $variant['color'];
                    $vProduct->price = $variant['price'];
                    $vProduct->purchase_price = $variant['purchase_price'];
                    $vProduct->stock = $variant['stock'];
                    $vProduct->description = $variant['description'];

                    if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $filename = time() . '_' . $variant['image']->getClientOriginalName();
                        $variant['image']->move(public_path('uploads/products'), $filename);
                        $vProduct->image = 'uploads/products/' . $filename;
                    }

                    $vProduct->save();
                }else{

                    $data['slug'] = $product->slug . '-' . ($key + 1);
                    $data['sku'] = $product->sku . '.' . ($key + 1);
                    // dd($data, $key, $variant);

                    $vProduct = Product::create($data);
                    $vProduct->name = $product->name.'-'.($key+1);
                    $vProduct->color = $variant['color'];
                    $vProduct->price = $variant['price'];
                    $vProduct->purchase_price = $variant['purchase_price'];
                    $vProduct->description = $variant['description'];
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
        $query = Product::query()->where('has_variants','0');

        if ($request->has('category_id') && $request->category_id !== null) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('sub_category_id') && $request->sub_category_id !== null) {
            $query->where('sub_category_id', $request->sub_category_id);
        }
        if ($request->has('brand_id') && $request->brand_id !== null) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->get();

        return response()->json([
            'products' => $products
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
}
