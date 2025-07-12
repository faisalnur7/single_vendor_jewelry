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

    public function processPayment(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method_nonce' => 'required|string',
        ]);

        $gateway = BraintreeGateway::getGateway();

        $result = $gateway->transaction()->sale([
            'amount' => $request->input('amount'),
            'paymentMethodNonce' => $request->input('payment_method_nonce'),
            'options' => ['submitForSettlement' => true],
        ]);

        if ($result->success) {
            $transactionId = $result->transaction->id;
            $paymentMethod = $result->transaction->paymentInstrumentType;

            // Save Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'billing_address' => $request->input('address'),
                'shipping_address' => $request->input('address'),
                'payment_option_name' => $paymentMethod,
                'payment_account_number' => '', // not available from Braintree
                'transaction_id' => $transactionId,
                'sender_phone_number' => $request->input('phone'),
                'status' => 'pending',
                'subtotal' => $request->input('amount'),
                'shipping_charge' => 0,
                'total' => $request->input('amount'),
                'order_tracking_number' => strtoupper(Str::random(10))
            ]);

            // Save Order Items
            $cartItems = Auth::check() ? Auth::user()->cart->items : session('guest_cart', []);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? $item->product_id,
                    'product_name' => $item['product_name'] ?? $item->product->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            // Clear cart
            if (Auth::check()) {
                Auth::user()->cart->items()->delete();
            } else {
                session()->forget('guest_cart');
            }

            return redirect()->route('payment.success')->with('success', 'Payment completed!');
        }

        return redirect()->route('payment.failed')->with('error', 'Payment failed: ' . $result->message);
    }


    public function success(Request $request)
    {
        $message = session('success') ?? 'Payment was successful!';
        return view('payment.success', compact('message'));
    }

    public function failed(Request $request)
    {
        $message = session('error') ?? 'Payment failed. Please try again.';
        return view('payment.failed', compact('message'));
    }


}
