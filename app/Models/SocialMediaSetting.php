<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaSetting extends Model
{
    protected $fillable = [
        'facebook', 'twitter', 'instagram', 'linkedin', 'youtube',
    ];
}
