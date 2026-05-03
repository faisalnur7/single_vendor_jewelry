<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\City;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\StripeGateway;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = [];
        $subtotal = 0;

        $data['shippingMethods'] = ShippingMethod::all();
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            if ($cart) {
                foreach ($cart->items as $item) {
                    $subtotal += $item->price * $item->quantity;
                    $cartItems[] = [
                        'product_id'   => $item->product_id,
                        'product_name' => $item->product->name ?? 'N/A',
                        'image'        => $item->product->image ?? null,
                        'quantity'     => $item->quantity,
                        'price'        => $item->price,
                        'subtotal'     => $item->price * $item->quantity,
                    ];
                }
            }
        } elseif (session()->has('guest_cart')) {
            foreach (session('guest_cart') as $item) {
                $price    = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $subtotal += $price * $quantity;
                $cartItems[] = [
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'] ?? 'N/A',
                    'image'        => $item['image'] ?? null,
                    'quantity'     => $quantity,
                    'price'        => $price,
                    'subtotal'     => $price * $quantity,
                ];
            }
        }

        $data['subtotal']  = $subtotal;
        $data['cartItems'] = $cartItems;
        $data['total']     = $subtotal;
        $data['countries'] = Country::all();
        $data['states']    = State::all();
        $data['cities']    = City::all();
        $data['stripeKey'] = config('services.stripe.key');

        return view('frontend.pages.checkout', $data);
    }

    public function createPaymentIntent(Request $request)
    {
        $amount = (float) $request->input('amount', 0);

        if ($amount <= 0) {
            return response()->json(['error' => 'Invalid amount'], 422);
        }

        $result = StripeGateway::createPaymentIntent($amount, 'USD');

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 422);
        }

        return response()->json(['clientSecret' => $result['client_secret']]);
    }

    public function processPayment(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent_id');

        $result = StripeGateway::retrievePaymentIntent($paymentIntentId);

        if (!$result['success']) {
            return redirect()->route('payment.failed')->with('error', 'Payment verification failed: ' . $result['error']);
        }

        $paymentIntent = $result['payment_intent'];

        if ($paymentIntent->status !== 'succeeded') {
            return redirect()->route('payment.failed')->with('error', 'Payment was not completed. Status: ' . $paymentIntent->status);
        }

        $order = Order::create([
            'user_id'                => Auth::id(),
            'billing_address'        => $request->input('address'),
            'shipping_address'       => $request->input('address'),
            'payment_option_name'    => 'stripe',
            'payment_account_number' => '',
            'transaction_id'         => $paymentIntent->id,
            'sender_phone_number'    => $request->input('phone'),
            'status'                 => 'paid',
            'subtotal'               => $request->input('amount'),
            'shipping_charge'        => 0,
            'total'                  => $request->input('amount'),
            'order_tracking_number'  => strtoupper(Str::random(10)),
            'shipping_method_id'     => $request->input('shipping_method_id'),
        ]);

        $cartItems = auth()->check() ? auth()->user()->cart->items : session('guest_cart', []);
        foreach ($cartItems as $item) {
            $productId   = is_array($item) ? $item['product_id']   : $item->product_id;
            $productName = is_array($item) ? $item['product_name']  : $item->product->name;
            $quantity    = is_array($item) ? $item['quantity']      : $item->quantity;
            $price       = is_array($item) ? $item['price']         : $item->price;

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $productId,
                'product_name' => $productName,
                'quantity'     => $quantity,
                'price'        => $price,
                'subtotal'     => $price * $quantity,
            ]);
        }

        if (auth()->check()) {
            auth()->user()->cart->items()->delete();
        } else {
            session()->forget('guest_cart');
        }

        return redirect()->route('payment.success', ['order_id' => $order->id])->with('success', 'Payment completed successfully!');
    }

    public function success(Request $request)
    {
        $order   = Order::findOrFail($request->order_id);
        $message = session('success') ?? 'Payment was successful!';
        return view('frontend.pages.success', compact('message', 'order'));
    }

    public function failed(Request $request)
    {
        $message = session('error') ?? 'Payment failed. Please try again.';
        return view('frontend.pages.failed', compact('message'));
    }
}
