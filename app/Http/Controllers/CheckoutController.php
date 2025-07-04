<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{


    public function checkout()
    {
        $cartItems = [];
        $subtotal = 0;
        $discount = 0;

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            if ($cart) {
                foreach ($cart->items as $item) {
                    $subtotal += $item->price * $item->quantity;

                    $cartItems[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name ?? 'N/A',
                        'image' => $item->product->image ?? null,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->price * $item->quantity,
                    ];
                }
            }

        } elseif (session()->has('guest_cart')) {
            foreach (session('guest_cart') as $item) {
                $price = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $subtotal += $price * $quantity;

                $cartItems[] = [
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'] ?? 'N/A',
                    'image' => $item['image'] ?? null,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                ];
            }
        }

        $total = $subtotal - $discount;

        return view('frontend.pages.checkout', compact('cartItems', 'subtotal', 'total'));
    }

}
