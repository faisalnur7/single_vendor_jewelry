<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildSubCategory extends Model
{
    protected $table = 'child_sub_categories';
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'image',
        'slug',
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

}
