@extends('frontend.layouts.main')
@section('title','Stainless Steel Jewelry')
@section('styles')
    <style>
        .zoom-container {
            position: relative;
            overflow: hidden;
        }

        .zoom-containe img:hover {
            transform: scale(1.5);
            transition: transform 0.3s ease;
        }

        /* Fixed Zoom Wrapper */
        #zoomWrapper.fixed {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-left: 0 !important;
            z-index: 9999;
        }

        /* Blur effect on product details */
        #productDetailsSection.blurred {
            filter: blur(5px);
            pointer-events: none;
            user-select: none;
        }
    </style>
@endsection
@section('contents')
    @include('frontend.partials._breadcrumbs')
    <section class="pt-0 pb-12 px-6">
        <div class="mx-auto p-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Image Viewer -->
                <div>
                    <div class="relative flex gap-4">
                        <!-- Main Image Full Width, Natural Height -->
                        <div class="relative  rounded overflow-hidden w-full">
                            <img id="mainImage" src="{{ asset($product->image) }}"
                                class="w-full h-auto object-contain transition-opacity duration-300 opacity-100" />
                            <div id="lens"
                                class="absolute pointer-events-none border border-gray-400 bg-white bg-opacity-40 rounded hidden">
                            </div>
                        </div>

                        <!-- Zoom Preview -->
                        <div id="zoomWrapper"
                            class="absolute left-full top-0 ml-6 w-[400px] h-[400px] border overflow-hidden rounded shadow-xl hidden z-50 bg-white">
                            <div id="result" class="w-full h-full bg-no-repeat bg-center bg-white"></div>
                        </div>
                    </div>

                    <div class="relative mt-4">
                        <!-- Navigation buttons -->
                        <div class="swiper-button-prev !left-0"></div>
                        <div class="swiper-button-next !right-0"></div>
                        <div class="swiper thumbnailSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($product->variants as $variant)
                                    <div class="swiper-slide w-24 cursor-pointer">
                                        <img onclick="changeImage(this.src, this)" src="{{ asset($variant->image) }}" data-product_details="{{ $variant->description }}" class="w-full border sw-item rounded" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details (dummy content) -->
                <div id="productDetailsSection"
                    class="w-full bg-white p-0 md:p-6 pt-0 rounded shadow-none relative transition-all duration-300">
                    <h2 class="text-sm md:text-xl font-semibold">{{ $product->name }}</h2>
                    {{-- <p class="mt-2 text-sm text-gray-600">From collection <span class="bg-black text-white px-2 py-1 rounded">Liora</span></p> --}}

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        {{-- <span class="text-xs border px-2 py-1 rounded-full">Fall & Winter Jewelry</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Gold Plated Jewelry</span>
                        <span class="text-xs border px-2 py-1 rounded-full">IHeart Collection</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Luxury Jewelry</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Stainless Steel Heart</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Water-Resistant Jewelry</span> --}}
                    </div>


                    <!-- Price Range -->
                    <p class="text-xl md:text-2xl font-semibold my-4 text-gray-600">${{ $product->variants->min('price') }} -
                        ${{ $product->variants->max('price') }}</p>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <div class="w-full border-gray-200 text-sm">
                            <!-- Header Row -->
                            <div class="grid grid-cols-3 bg-gray-100 text-gray-700 font-bold text-xs sm:text-sm">
                                <div class="p-2">Color</div>
                                <div class="p-2 text-center">Price</div>
                                <div class="p-2 text-center">Qty</div>
                            </div>

                            <!-- Data Rows -->
                            <div class="max-h-[500px] overflow-y-auto overflow-x-auto">
                                @foreach ($product->variants as $index => $variant)
                                    <div onclick="changeImage('{{ asset($variant->image) }}', this)"
                                        data-image="{{ asset($variant->image) }}"
                                        data-product_details="{{ $variant->description }}"
                                        class="grid grid-cols-3 items-center mt-1 border border-gray-300 variant_row hover:bg-gray-50 hover:border-black cursor-pointer text-xs sm:text-sm min-w-[320px]">
                                        
                                        <!-- Color + Image -->
                                        <div class="p-2 flex items-center gap-2">
                                            <img src="{{ asset($variant->image) }}"
                                                class="w-12 h-12 object-cover rounded" />
                                            <span class="whitespace-normal break-words">{{ $variant->color }}</span>
                                        </div>

                                        <!-- Price -->
                                        <div class="p-2 font-semibold text-center pr-6">${{ $variant->price }}</div>

                                        <!-- Quantity Controls -->
                                        <div class="p-2 flex justify-center text-center">
                                            <div class="flex items-center justify-center gap-2 pdp_quantity">
                                                <button class="qty-decrease px-2 py-1 border rounded"
                                                    data-index="{{ $index }}" data-product_id="{{ $variant->id }}"
                                                    data-price="{{ $variant->price }}">-</button>
                                                <span id="qty-{{ $index }}">0</span>
                                                <button class="qty-increase px-2 py-1 border rounded"
                                                    data-index="{{ $index }}" data-product_id="{{ $variant->id }}"
                                                    data-price="{{ $variant->price }}">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- Add to Cart -->
                    <div class="mt-6 flex items-center justify-between text-white rounded gap-4">
                        <button
                            class="flex items-center gap-2 text-white justify-center  bg-black w-full p-3 rounded-md add_to_cart_btn">
                            🛒 <span>ADD TO CART</span> <span id="cartTotal">(0 items - $0.00)</span>
                        </button>
                        <button class="hidden md:flex border p-3 rounded-md border-gray-800 text-black wishlist_btn" data-product_id="{{$product->id}}">
                            <i class="fa-regular fa-heart heart_icon"></i>
                        </button>
                    </div>

                    @php
                        $paymentIcons = [
                            'paypal',
                            'visa',
                            'master',
                            'discover',
                            'american_express',
                            'amazon',
                            'google_pay',
                            'jcb',
                            'venmo',
                            'elo',
                            'unionpay',
                        ];

                        $payment_image_class = 'w-12 h-8 object-contain';
                    @endphp

                    <div class="mt-6 flex items-center justify-start flex-wrap gap-1">
                        @foreach ($paymentIcons as $icon)
                            <img src="{{ asset('assets/img/payment_icons/' . $icon . '.svg') }}"
                                title="{{ ucwords(str_replace('_', ' ', $icon)) }}" class="{{ $payment_image_class }}" />
                        @endforeach
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Product Description</h3>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Product Details</h3>
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2 product_details">
                            {!! $product->variants->first()->description !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @include('frontend.pages.scripts.pdp_scripts')
@endsection
