@extends('frontend.layouts.checkout_template')
@section('title', 'Checkout')
@section('styles')
<style>
/* Hide scrollbar but allow scroll */
.scroll-hidden {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
}
.scroll-hidden::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

</style>
@endsection
@section('contents')
<section class="bg-transparent">
    <div class="w-full mx-auto h-[100vh] flex justify-center">
        <!-- Left: Checkout Form (Scrollable) -->
        <div class="w-1/2 max-w-[600px] bg-white p-6 overflow-y-auto max-h-[100vh] scroll-hidden">
            <!-- Express Checkout -->
            <h2 class="text-xl font-semibold mb-4">Express checkout</h2>
            <div class="flex gap-4 mb-6">
                <button class="bg-yellow-400 hover:bg-yellow-300 px-6 py-3 rounded font-semibold">PayPal</button>
                <button class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded font-semibold">G Pay</button>
            </div>

            <div class="border-t py-6 space-y-6">
                <!-- Account -->
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" placeholder="you@example.com"
                        class="w-full border-gray-200 px-4 py-2 rounded focus:outline-none focus:ring" />
                </div>

                <!-- Delivery -->
                <h3 class="text-lg font-semibold">Delivery</h3>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" placeholder="First name" class="border-gray-200 px-4 py-2 rounded w-full" />
                    <input type="text" placeholder="Last name" class="border-gray-200 px-4 py-2 rounded w-full" />
                </div>
                <input type="text" placeholder="Address" class="border-gray-200 px-4 py-2 rounded w-full mt-4" />
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <input type="text" placeholder="City" class="border-gray-200 px-4 py-2 rounded w-full" />
                    <input type="text" placeholder="Postal code" class="border-gray-200 px-4 py-2 rounded w-full" />
                </div>
                <input type="text" placeholder="Phone (optional)" class="border-gray-200 px-4 py-2 rounded w-full mt-4" />

                <!-- Payment -->
                <h3 class="text-lg font-semibold mt-6">Payment</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="payment" checked />
                        <label class="text-sm font-medium">Credit/Debit Card</label>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="h-5 ml-2" />
                    </div>

                    <input type="text" placeholder="Card number" class="border-gray-200 px-4 py-2 rounded w-full" />
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" placeholder="MM/YY" class="border-gray-200 px-4 py-2 rounded w-full" />
                        <input type="text" placeholder="CVC" class="border-gray-200 px-4 py-2 rounded w-full" />
                    </div>
                </div>

                <!-- Billing -->
                <h3 class="text-lg font-semibold mt-6">Billing address</h3>
                <input type="text" placeholder="Address" class="border-gray-200 px-4 py-2 rounded w-full" />
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <input type="text" placeholder="City" class="border-gray-200 px-4 py-2 rounded w-full" />
                    <input type="text" placeholder="Postal code" class="border-gray-200 px-4 py-2 rounded w-full" />
                </div>

                <button class="mt-6 w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700 transition">
                    Pay now
                </button>
            </div>
        </div>

        <!-- Right: Order Summary (Sticky) -->
        <div class="w-1/2 max-w-[600px] bg-white p-6 h-fit sticky top-6 self-start">
            <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach ($cartItems as $item)
                    <div class="flex items-start gap-4 border-b pb-4">
                        <img src="{{ asset($item['image']) }}" class="w-16 h-16 object-cover rounded" />
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ $item['product_name'] }}</p>
                            <p class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <p class="text-sm font-semibold">${{ number_format($item['subtotal'], 2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="pt-6 mt-6 border-t">
                <div class="flex justify-between text-sm">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-gray-900 mt-2">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
