<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function cart(Request $request){
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $cart = Cart::with(['items.product'])->where('user_id', $user->id)->first();

        $subtotal = 0;

        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $subtotal += $item->price * $item->quantity;
            }
        }

        $total = $subtotal;

        return view('prime_user.product_purchase.cart_page', compact('cart', 'subtotal', 'total'));
    }
    // public function add_to_cart(Request $request){
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //     ]);

    //     $user = auth()->user();

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Please log in to add items to cart.'
    //         ], 401);
    //     }

    //     // Get or create Cart for the user
    //     $cart = Cart::firstOrCreate(['user_id' => $user->id]);

    //     // Check if item already exists
    //     $cartItem = CartItem::where('prime_cart_id', $cart->id)
    //         ->where('product_id', $request->product_id)
    //         ->first();

    //     if ($cartItem) {
    //         // Increase quantity
    //         $cartItem->increment('quantity');
    //     } else {
    //         // Add new item
    //         CartItem::create([
    //             'prime_cart_id' => $cart->id,
    //             'product_id' => $request->product_id,
    //             'quantity' => 1,
    //             'price' => $request->price ?? 0,
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Product added to cart successfully!',
    //         'html' => view('layouts.partials._top_cart')->render()
    //     ]);
    // }


    public function add_to_cart(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            $cartItem = CartItem::where('prime_cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $request->quantity);
            } else {
                CartItem::create([
                    'prime_cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $request->price,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
            ]);
        }

        // Guest: store in session
        $cart = session()->get('guest_cart', []);
        $key = $request->product_id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ];
        }

        session()->put('guest_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to guest cart',
        ]);
    }


    public function remove_item(Request $request){
        $user = auth()->user();
        $item = CartItem::where('id', $request->item_id)
            ->whereHas('cart', fn($q) => $q->where('user_id', $user->id))
            ->firstOrFail();

        $item->delete();

        $cart = Cart::with(['items.product'])->where('user_id', $user->id)->first();
        $view = view('layouts.partials._top_cart', compact('cart'))->render();
        $cartView = view('prime_user.product_purchase.partials.cart_item', compact('cart'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'view' => $view,
            'cart_view' => $cartView
        ]);
    }


    public function update_item_qty(Request $request){
        $request->validate(['quantity' => 'required|integer|min:1']);
        $user = auth()->user();

        $item = CartItem::findOrFail($request->id);

        if ($item->cart->user_id !== auth()->id()) {
            return response()->json(['success' => false], 403);
        }

        $item->quantity = $request->quantity;
        $item->save();

        $cart = Cart::with(['items.product'])->where('user_id', $user->id)->first();
        $view = view('layouts.partials._top_cart', compact('cart'))->render();


        return response()->json([
            'success' => true,
            'view' => $view
        ]);
    }
}
