@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
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

        #mainImage {
            cursor: zoom-in;
            transform-origin: center center;
            /* Will update with mouse move */
        }

        .thumbnailSwiper {
            height: 400px;
            /* adjust as needed */
        }

        .swiper-button-next,
        .swiper-button-prev {
            left: 50%;
            transform: translateX(-50%);
        }

        .swiper-button-next {
            top: auto;
            bottom: 0;
        }

        .swiper-button-prev {
            top: 0;
        }

        .thumbnailSwiper .swiper-slide {
            aspect-ratio: 1 / 1;
            /* makes each slide a square */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnailSwiper .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* crop/cover inside the square */
            border-radius: 6px;
            /* optional rounded edges */
        }
    </style>
@endsection
@section('contents')
    <section class="pt-6 pb-12 px-6">
        <div class="mx-auto p-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Image Viewer -->
                <div class="flex flex-row-reverse gap-2 justify-end items-start">
                    <div class="relative flex gap-4 w-full justify-center border rounded-md">
                        <!-- Main Image Natural Width, Fixed Height -->
                        <div class="relative overflow-hidden ">
                            <img id="mainImage" src="{{ asset($product->image) }}"
                                class="h-[800px] w-auto object-contain transition-opacity duration-300 opacity-100" />
                        </div>
                    </div>


                    <div class="relative mt-4 h-full">
                        <!-- Navigation buttons -->
                        <div class="swiper-button-prev !left-0"></div>
                        <div class="swiper-button-next !right-0"></div>
                        <div class="swiper thumbnailSwiper">
                            <div class="swiper-wrapper h-full">
                                @foreach ($product->variants as $variant)
                                    <div class="swiper-slide w-32 h-36 aspect-square cursor-pointer">
                                        <img onclick="changeImage(this.src, this)" src="{{ asset($variant->image) }}"
                                            data-product_details="{{ $variant->description }}"
                                            class="w-full h-full object-cover sw-item rounded" />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Product Details (dummy content) -->
                <div id="productDetailsSection"
                    class="w-full bg-white p-0 md:p-6 md:pt-0 pt-0 rounded shadow-none relative transition-all duration-300">
                    @include('frontend.partials._breadcrumbs')

                    <h2 class="text-sm md:text-xl font-semibold" data-translate>{{ $product->name }}</h2>
                    {{-- <p class="mt-2 text-sm text-gray-600">From collection <span class="bg-black text-white px-2 py-1 rounded">Liora</span></p> --}}
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach ($product?->category?->subcategories as $subcategory)
                            <span
                                class="text-sm border px-2 py-1 rounded-full hover:bg-black hover:text-white transition-all duration-300">{{ $subcategory->name }}</span>
                        @endforeach
                    </div>


                    <!-- Price Range -->
                    <p class="text-xl md:text-2xl font-semibold my-4 text-gray-600">
                        {{ show_price_range($product->variants) }}</p>

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
                                            <span class="whitespace-normal break-words"
                                                data-translate>{{ $variant->color }}</span>
                                        </div>

                                        <!-- Price -->
                                        <div class="p-2 font-semibold text-center pr-6">{{ show_price($variant) }}</div>

                                        <!-- Quantity Controls -->
                                        <div class="p-2 flex justify-center text-center">
                                            <div class="flex items-center justify-center gap-2 pdp_quantity">
                                                <button class="qty-decrease px-2 py-1 border rounded"
                                                    data-index="{{ $index }}" data-product_id="{{ $variant->id }}"
                                                    data-price="{{ $variant->price }}"
                                                    data-price_rmb="{{ $variant->price_rmb }}">-</button>
                                                <span id="qty-{{ $index }}">0</span>
                                                <button class="qty-increase px-2 py-1 border rounded"
                                                    data-index="{{ $index }}" data-product_id="{{ $variant->id }}"
                                                    data-price="{{ $variant->price }}"
                                                    data-price_rmb="{{ $variant->price_rmb }}">+</button>
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
                        <button class="hidden md:flex border p-3 rounded-md border-gray-800 text-black wishlist_btn"
                            data-product_id="{{ $product->id }}">
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
                        <p class="text-sm text-gray-600 mt-2" data-translate>
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Product Details</h3>
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2 product_details" data-translate>
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
