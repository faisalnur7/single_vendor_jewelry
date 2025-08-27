<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show all wishlist items for the logged-in user
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->latest()->get();
        return view('frontend.user.wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        if (!Auth::check()) {
            // Guest user → handled in JS (sessionStorage)
            return response()->json([
                'guest' => true,
                'message' => 'User not logged in. Store in session.'
            ], 200);
        }

        $user = auth()->user();

        if ($user->wishlists()->where('product_id', $request->product_id)->exists()) {
            return response()->json([
                'error' => 'Product already in wishlist.'
            ], 409);
        }

        $user->wishlists()->create([
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => 'Product added to wishlist.'
        ]);
    }

    // Remove a product from wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::query()->findOrFail($id);
        // $this->authorize('delete', $wishlist);
        $wishlist->delete();
        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }

    public function guest_wishlist(){
        return view('frontend.user.wishlist.guest_wishlist');
    }

    public function guestProducts(Request $request){
        $ids = $request->input('ids', []);
        $products = Product::whereIn('id', $ids)->get(['id','name','image','slug']);
        return response()->json(['products' => $products]);
    }
}

