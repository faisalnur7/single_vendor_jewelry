<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['category_id','name','slug','image'];

    public function categories() {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function child_sub_categories(){
        return $this->hasMany(ChildSubCategory::class,'subcategory_id');
    }
}
