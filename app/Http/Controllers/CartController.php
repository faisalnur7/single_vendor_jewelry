<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function cart(){
        $user = auth()->user();

        if ($user) {
            // Get user cart and load items with product details
            $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

            if (!$cart || $cart->items->isEmpty()) {
                $cartItems = [];
                return view('frontend.pages.cart', compact('cartItems'));
            }
            
            $cartItems = $cart->items;
            return view('frontend.pages.cart', compact('cartItems'));
        }

        // Guest cart from session
        $guestCart = session()->get('guest_cart', []);

        if (empty($guestCart)) {
            $cartItems = [];
            return view('frontend.pages.cart', compact('cartItems'));
        }

        // Load product details for guest cart
        $productIds = array_keys($guestCart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = [];
        foreach ($guestCart as $productId => $item) {
            $product = $products[$productId] ?? null;
            $cartItems[] = [
                'product_id' => $productId,
                'product_name' => $product->name ?? 'N/A',
                'color' => $product->color ?? 'N/A',
                'image' => $product->image ?? 'N/A',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ];
        }

        return view('frontend.pages.cart', compact('cartItems'));
    }


    public function add_to_cart(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($request->items as $item) {
                $product = Product::query()->findOrFail($item['product_id']);
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity', $item['quantity']);
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $item['product_id'],
                        'image' => $product->image,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }

            return response()->json([
                'cart' => count($cart->items),
                'success' => true,
                'message' => 'Products added to cart successfully!',
            ]);
        }

        // Guest (not logged in)
        $cart = session()->get('guest_cart', []);

        foreach ($request->items as $item) {
            $key = $item['product_id'];
            $product = Product::query()->findOrFail($item['product_id']);
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $item['quantity'];
            } else {
                $cart[$key] = [
                    'product_id' => $item['product_id'],
                    'image' => $product->image,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
            }
        }

        session()->put('guest_cart', $cart);


        return response()->json([
            'cart' => count($cart),
            'success' => true,
            'message' => 'Products added to cart',
        ]);
    }



    public function remove($productId){
        $user = auth()->user();

        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
            }
        } else {
            $cart = session()->get('guest_cart', []);
            unset($cart[$productId]);
            session()->put('guest_cart', $cart);
        }

        return response()->json(['success' => true]);
    }



    public function update_item_qty(Request $request){
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
            if ($cart) {
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $request->product_id)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity = $request->quantity;
                    $cartItem->save();
                }
            }
        } else {
            $cart = session()->get('guest_cart', []);
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] = $request->quantity;
                session()->put('guest_cart', $cart);
            }
        }

        return response()->json(['success' => true, 'message' => 'Cart updated']);
    }
}
