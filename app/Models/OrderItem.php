<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'quantity',
        'price',
        'subtotal',
    ];
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
