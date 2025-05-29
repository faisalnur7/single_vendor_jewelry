<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'child_sub_category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'max_price',
        'min_price',
        'price',
        'min_order_qty',
        'stock',
        'parent_id',
        'image',
        'status',
        'featured',
        'weight',
        'unit',
        'meta',
        'has_variants'
    ];

    protected $casts = [
        'meta' => 'array',
        'featured' => 'boolean',
        'max_price' => 'float',
        'min_price' => 'float',
        'min_order_qty' => 'float',
        'weight' => 'float',
        'has_variant' => 'integer',
    ];

    const MAIN_PRODUCT_ONLY = 1;
    const VARIANTS_ONLY = 2;
    const BOTH = 3;

    const VIEW_OPTIONS = [
        self::MAIN_PRODUCT_ONLY => "Main products",
        self::VARIANTS_ONLY => "Variants",
        self::BOTH => "Both",
    ];


    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function subCategory() {
        return $this->belongsTo(SubCategory::class);
    }

    public function childSubCategory() {
        return $this->belongsTo(ChildSubCategory::class);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function variants()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

}
