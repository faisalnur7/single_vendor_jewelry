<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOffice extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','bn_name', 'url', 'post_code','status', 'police_station_id'];

    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class);
    }
}
