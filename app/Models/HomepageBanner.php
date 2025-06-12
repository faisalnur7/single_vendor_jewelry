<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageBanner extends Model
{
    protected $fillable = [
        'category_id',
        'banner',
        'status'
    ];
}
