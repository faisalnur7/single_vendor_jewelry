<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\BraintreeGateway;

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
        
        $data['subtotal'] = $subtotal;
        $data['cartItems'] = $cartItems;
        $data['total'] = $subtotal;
        $data['countries'] = Country::all();
        $data['states'] = State::all();
        $data['cities'] = City::all();

        $gateway = BraintreeGateway::getGateway();
        $data['clientToken'] = $clientToken = $gateway->clientToken()->generate();

        return view('frontend.pages.checkout', $data);
    }

    public function processPayment(Request $request)
    {
        $gateway = BraintreeGateway::getGateway();

        $amount = 100.00; // dynamically set from cart total
        $nonce = $request->input('payment_method_nonce');

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            return redirect()->route('payment.success')->with('success', 'Payment successful!');
        } else {
            return back()->with('error', 'Payment failed: ' . $result->message);
        }
    }

}
