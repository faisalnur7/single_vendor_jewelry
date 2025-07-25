<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','image'];

    public function subcategories() {
        return $this->hasMany(SubCategory::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }

}
