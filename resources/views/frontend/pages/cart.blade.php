@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('contents')

    <section class="mt-24 pt-0 pb-12 px-6">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-2xl font-semibold mb-6">Cart</h2>

            @if (count($cartItems) > 0)
                <div class="">
                    @php $total = 0; @endphp

                    <div class="px-4 py-3 border-b font-medium text-lg">
                        <div class="flex flex-wrap items-center text-gray-900">
                            <div class="w-full sm:w-5/12">PRODUCT</div>
                            <div class="w-1/3 sm:w-3/12 text-center">PRICE</div>
                            <div class="w-1/3 sm:w-2/12 text-center">QUANTITY</div>
                            <div class="w-1/3 sm:w-2/12 text-right sm:text-end">TOTAL</div>
                        </div>
                    </div>

                    @foreach ($cartItems as $item)
                        @php
                            $isArray = is_array($item);

                            $image = $isArray
                                ? $item['image'] ?? ($item['product']['image'] ?? '')
                                : $item->image ?? $item->product->image;
                            $product_name = $isArray
                                ? $item['product_name'] ?? ($item['product']['name'] ?? '')
                                : $item->product_name ?? $item->product->name;
                            $color = $isArray
                                ? $item['color'] ?? ($item['product']['color'] ?? '')
                                : $item->color ?? $item->product->color;
                            $price = $isArray
                                ? $item['price'] ?? ($item['product']['price'] ?? 0)
                                : $item->price ?? $item->product->price;
                            $quantity = $isArray ? $item['quantity'] ?? 1 : $item->quantity ?? 1;
                            $product_id = $isArray ? $item['product_id'] ?? null : $item->product_id ?? null;

                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                        @endphp
                        <div class="bg-white p-4 border-b" data-id="{{ $product_id }}">
                            <div class="flex flex-wrap items-center">
                                <!-- Product (w-5/12) -->
                                <div class="w-full sm:w-5/12 flex items-center gap-3">
                                    <div class="w-96 overflow-hidden rounded">
                                        <img src="{{ asset($image) }}"
                                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" />
                                    </div>
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-900">
                                            {{ $product_name }}
                                        </h3>
                                        <p>Color: {{ $color }}</p>
                                        <button type="button"
                                            class="delete-cart-item-btn text-orange-600 hover:text-orange-700 text-lg font-bold"
                                            data-id="{{ $product_id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>

                                </div>

                                <!-- Price (w-3/12) -->
                                <div class="w-1/2 sm:w-3/12 text-center mt-4 sm:mt-0">
                                    <p class="text-xl text-gray-800" data-price="{{ $price }}"
                                        data-id="{{ $product_id }}">${{ number_format($price, 2) }}</p>
                                </div>

                                <!-- Quantity (w-2/12) -->
                                <div class="w-1/2 sm:w-2/12 text-center mt-4 sm:mt-0 flex justify-center items-center">
                                    <button type="button"
                                        class="decrease-qty h-10 px-3 rounded-l-full border border-gray-400 border-r-0 text-black"
                                        data-id="{{ $product_id }}">−</button>

                                    <input type="number" min="1" value="{{ $quantity }}"
                                        class="w-14 h-10 text-xl text-center border border-gray-400 border-r-0 border-l-0 quantity-input"
                                        data-id="{{ $product_id }}">

                                    <button type="button"
                                        class="increase-qty h-10 px-3 rounded-r-full border border-gray-400 border-l-0 text-black"
                                        data-id="{{ $product_id }}">+</button>
                                </div>

                                <!-- Subtotal + Remove (w-2/12) -->
                                <div
                                    class="w-full sm:w-2/12 mt-4 sm:mt-0 flex justify-between sm:justify-end items-center gap-4">
                                    <p class="text-xl font-semibold text-gray-800 subtotal" data-id="{{ $product_id }}">
                                        ${{ number_format($subtotal, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Cart Total + Checkout -->
                    <div class="text-right mt-6 pt-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 cart-total">
                            Total: ${{ number_format($total, 2) }}
                        </h3>

                        <a href="{{ route('checkout') }}"
                            class="inline-block bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition checkout-trigger">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">Your cart is empty!</p>
                    <p>Start adding products to your cart.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    @include('frontend.pages.scripts.cart_scripts')
@endsection
