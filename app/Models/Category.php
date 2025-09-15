<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','image','is_trending','is_featured','show_on_main_menu','order'];

    public function subcategories() {
        return $this->hasMany(SubCategory::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function subcategoriesSorted()
    {
        return $this->hasMany(SubCategory::class)->orderBy('order', 'asc');
    }


}
