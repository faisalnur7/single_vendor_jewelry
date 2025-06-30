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
                return response()->json([
                    'success' => true,
                    'cart' => [],
                    'message' => 'Cart is empty',
                ]);
            }

            return response()->json([
                'success' => true,
                'cart' => $cart->items->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name ?? 'N/A',
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->price * $item->quantity,
                    ];
                }),
            ]);
        }

        // Guest cart from session
        $guestCart = session()->get('guest_cart', []);

        if (empty($guestCart)) {
            return response()->json([
                'success' => true,
                'cart' => [],
                'message' => 'Guest cart is empty',
            ]);
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
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ];
        }

        return response()->json([
            'success' => true,
            'cart' => $cartItems,
        ]);
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
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity', $item['quantity']);
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $item['product_id'],
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

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $item['quantity'];
            } else {
                $cart[$key] = [
                    'product_id' => $item['product_id'],
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
