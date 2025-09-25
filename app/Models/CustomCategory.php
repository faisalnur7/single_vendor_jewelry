<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCategory extends Model
{
    protected $fillable = ['category_id','sub_category_id','child_sub_category_id','name','slug','image','order','type'];

    const TRENDING = 1;
    const FEATURED = 2;
    const MAY_LIKED = 3;

    const CUSTOM_CATEGORY_TYPE = [
        self::TRENDING => 'Wholesale Trending Discovery',
        self::FEATURED => 'Featured Categories',
        self::MAY_LIKED => 'Products You May Like',
    ];

    public function category(){
        return $this->belongsTo(Category::class)->where('show_on_main_menu', 1);
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childsubcategory(){
        return $this->belongsTo(ChildSubCategory::class, 'child_sub_category_id');
    }

}