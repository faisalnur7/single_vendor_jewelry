<?php

namespace App\Http\Controllers\Traits;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

trait MergesGuestCart
{
    public function mergeGuestCartIntoUserCart()
    {
        if (session()->has('guest_cart')) {
            $guestCart = session('guest_cart');
            $user = Auth::user();

            // Get or create a cart for the user
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($guestCart as $item) {
                // Either update existing or create new
                $existing = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($existing) {
                    $existing->quantity += $item['quantity'];
                    $existing->save();
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }

            session()->forget('guest_cart');
        }
    }
}
