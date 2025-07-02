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
                        @php $total += $item['subtotal']; @endphp

                        <div class="bg-white shadow-md rounded-lg p-4 relative border">
                            <div class="flex md:flex-row items-center md:items-center justify-between gap-0">
                                <div class="w-full flex flex-col md:flex-row gap-2 md:gap-12 items-center justify-between">
                                    <div class="product_img w-28 overflow-hidden">
                                        <img src="{{ asset($item['image']) }}"
                                            class="w-full object-cover transition-transform duration-300 hover:scale-110" />
                                    </div>

                                    <h3 class="text-sm font-semibold text-gray-900 max-w-md">{{ $item['color'] }} |
                                        {{ $item['product_name'] }}</h3>
                                    <p class="text-md text-gray-950" data-price="{{ $item['price'] }}">
                                        Price: ${{ number_format($item['price'], 2) }}
                                    </p>


                                    <!-- Quantity Control -->
                                    <div class="mt-2 flex items-center justify-start gap-0">
                                        <button type="button"
                                            class="decrease-qty h-11 px-3 py-2 rounded-l-full border border-gray-600 border-r-0 text-black m-0 "
                                            data-id="{{ $item['product_id'] }}">−</button>
                                        <input type="number" min="1" value="{{ $item['quantity'] }}"
                                            class="w-16 h-11 text-center border border-gray-600 border-r-0 border-l-0 quantity-input"
                                            data-id="{{ $item['product_id'] }}">
                                        <button type="button"
                                            class="increase-qty h-11 px-3 py-2 rounded-r-full border border-gray-600 border-l-0 text-black m-0 "
                                            data-id="{{ $item['product_id'] }}">+</button>
                                    </div>


                                    <div class="text-right flex gap-4 items-center">
                                        <p class="text-md font-semibold text-gray-800 subtotal"
                                            data-id="{{ $item['product_id'] }}">
                                            Subtotal: ${{ number_format($item['subtotal'], 2) }}
                                        </p>


                                        <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST"
                                            onsubmit="return confirm('Remove this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-700 hover:text-red-800 text-lg font-bold">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Subtotal -->

                            </div>
                        </div>
                    @endforeach

                    <!-- Cart Total + Checkout -->
                    <div class="text-right mt-6 border-t pt-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 cart-total">
                            Total: ${{ number_format($total, 2) }}
                        </h3>

                        <a href="{{ route('checkout.page') }}"
                            class="inline-block bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition">
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
