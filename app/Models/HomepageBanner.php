<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageBanner extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'child_sub_category_id',
        'banner',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->where('show_on_main_menu', 1);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childSubCategory()
    {
        return $this->belongsTo(ChildSubCategory::class, 'child_sub_category_id');
    }
}
