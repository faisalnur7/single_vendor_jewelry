<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    protected $fillable = [
        'why_choose_us',
        'about',
        'down_paragraph'
    ];
}
