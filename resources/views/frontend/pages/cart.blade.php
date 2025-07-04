@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('contents')

    <section class="mt-24 pt-0 pb-12 px-6">
        <div class="mx-auto max-w-7xl">
            <h2 class="text-2xl font-semibold mb-6">Cart</h2>

            @if (count($cartItems) > 0)
                <div class="space-y-4">
                    @php $total = 0; @endphp

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

                        <div class="bg-white shadow-md rounded-lg p-4 relative border">
                            <div class="flex md:flex-row items-center justify-between gap-6 flex-wrap">
                                <div class="product_img w-28 overflow-hidden">
                                    <img src="{{ asset($image) }}"
                                        class="w-full object-cover transition-transform duration-300 hover:scale-110" />
                                </div>

                                <h3 class="text-sm font-semibold text-gray-900 max-w-md">{{ $color }} |
                                    {{ $product_name }}</h3>

                                <p class="text-md text-gray-950" data-price="{{ $price }}">
                                    Price: ${{ number_format($price, 2) }}
                                </p>

                                <!-- Quantity Control -->
                                <div class="flex items-center">
                                    <button type="button"
                                        class="decrease-qty h-11 px-3 py-2 rounded-l-full border border-gray-600 border-r-0 text-black"
                                        data-id="{{ $product_id }}">−</button>

                                    <input type="number" min="1" value="{{ $quantity }}"
                                        class="w-16 h-11 text-center border border-gray-600 border-r-0 border-l-0 quantity-input"
                                        data-id="{{ $product_id }}">

                                    <button type="button"
                                        class="increase-qty h-11 px-3 py-2 rounded-r-full border border-gray-600 border-l-0 text-black"
                                        data-id="{{ $product_id }}">+</button>
                                </div>

                                <!-- Subtotal + Remove -->
                                <div class="text-right flex gap-4 items-center">
                                    <p class="text-md font-semibold text-gray-800 subtotal" data-id="{{ $product_id }}">
                                        Subtotal: ${{ number_format($subtotal, 2) }}
                                    </p>

                                    {{-- <form method="POST" class="delete-cart-item-form" action="{{route('cart.remove', $product_id)}}"
                                        data-product-id="{{ $product_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-700 hover:text-red-800 text-lg font-bold">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form> --}}
                                    <button type="button"
                                        class="delete-cart-item-btn text-gray-700 hover:text-red-800 text-lg font-bold"
                                        data-id="{{ $product_id }}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Cart Total + Checkout -->
                    <div class="text-right mt-6 border-t pt-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 cart-total">
                            Total: ${{ number_format($total, 2) }}
                        </h3>

                        <a href="{{ route('checkout.page') }}"
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
