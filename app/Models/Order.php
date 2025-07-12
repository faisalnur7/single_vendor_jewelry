<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'billing_address',
        'shipping_address',
        'payment_option_name',
        'transaction_id',
        'status',
        'subtotal',
        'shipping_charge',
        'total',
        'order_tracking_number',
        'order_tracking_url',
        'start_processing_at',
        'packaged_at',
        'shipped_at',
        'completed_at'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }


}
