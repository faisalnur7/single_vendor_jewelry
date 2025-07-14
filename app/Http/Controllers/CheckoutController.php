<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\BraintreeGateway;
use Illuminate\Support\Str;

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
        // dd($request->all());
        // $request->validate([
        //     'amount' => 'required|numeric|min:0.01',
        //     'payment_method_nonce' => 'required|string',
        //     'address' => 'required|string|max:255',
        //     'phone' => 'required|string|max:20',
        // ]);

        $gateway = BraintreeGateway::getGateway();

        try {
            $result = $gateway->transaction()->sale([
                'amount' => $request->input('amount'),
                'paymentMethodNonce' => $request->input('payment_method_nonce'),
                'options' => ['submitForSettlement' => true],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('payment.failed')->with('error', 'Payment error: ' . $e->getMessage());
        }

        if ($result->success) {
            $transaction = $result->transaction;
            $transactionId = $transaction->id;
            $paymentMethod = $transaction->paymentInstrumentType;
            $status = $transaction->status;

            // Save Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'billing_address' => $request->input('address'),
                'shipping_address' => $request->input('address'),
                'payment_option_name' => $paymentMethod,
                'payment_account_number' => '', // Not provided by Braintree
                'transaction_id' => $transactionId,
                'sender_phone_number' => $request->input('phone'),
                'status' => $status, // Use real status like 'submitted_for_settlement'
                'subtotal' => $request->input('amount'),
                'shipping_charge' => 0,
                'total' => $request->input('amount'),
                'order_tracking_number' => strtoupper(Str::random(10)),
                'braintree_response' => json_encode($transaction), // Optional logging
            ]);

            // Save Order Items
            $cartItems = auth()->check() ? auth()->user()->cart->items : session('guest_cart', []);
            foreach ($cartItems as $item) {
                $productId = is_array($item) ? $item['product_id'] : $item->product_id;
                $productName = is_array($item) ? $item['product_name'] : $item->product->name;
                $quantity = is_array($item) ? $item['quantity'] : $item->quantity;
                $price = is_array($item) ? $item['price'] : $item->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                ]);
            }

            // Clear cart
            if (auth()->check()) {
                auth()->user()->cart->items()->delete();
            } else {
                session()->forget('guest_cart');
            }

            return redirect()->route('payment.success')->with('success', 'Payment completed successfully!');
        }

        return redirect()->route('payment.failed')->with('error', 'Payment failed: ' . $result->message);
    }



    public function success(Request $request)
    {
        $message = session('success') ?? 'Payment was successful!';
        return view('frontend.pages.success', compact('message'));
    }

    public function failed(Request $request)
    {
        $message = session('error') ?? 'Payment failed. Please try again.';
        return view('frontend.pages.failed', compact('message'));
    }


}
