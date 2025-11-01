@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('styles')
    <style>
        /* Blur effect on product details */
        #mainImage {
            cursor: zoom-in;
            transform-origin: center center;
            /* Will update with mouse move */
        }

        .thumbnailSwiper {
            height: auto;
        }

        .thumbnailSwiper .swiper-slide {
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnailSwiper .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        .prose p {
            margin-bottom: 0.5rem;
            line-height: 1.2 !important;
        }

        .prose span {
            display: inline;
        }

        /* Hide default arrow icons */
        .swiper-button-next::after,
        .swiper-button-prev::after {
            display: none;
        }

        .swiper-button-next,
        .swiper-button-prev {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.45);
            border-radius: 50%;
            color: white;
            font-size: 18px;
            position: absolute;
            top: 50%;
            z-index: 10;
            transition: .3s;
        }

        .swiper-button-prev {
            left: 24px;
        }

        .swiper-button-next {
            right: 24px;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }
    </style>
@endsection
@section('contents')
    <section class="pt-6 pb-12 px-6">
        <div class="mx-auto p-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Image Viewer -->
                <div class="flex flex-col gap-2 self-start sticky top-24 max-h-screen">
                    <div class="relative flex gap-4 w-full justify-center border rounded-md">
                        <!-- Main Image Natural Width, Fixed Height -->
                        <div class="relative overflow-hidden">
                            <img id="mainImage" src="{{ asset($product->image) }}"
                                class="h-auto md:h-[600px] w-auto object-contain transition-opacity duration-300 opacity-100" />
                        </div>
                    </div>

                    <div class="relative lg:mt-4 h-full">
                        <!-- Navigation buttons -->

                        <div class="swiper thumbnailSwiper">
                            <div class="swiper-button-prev">
                                <i class="fa-solid fa-chevron-left"></i>
                            </div>
                            <div class="swiper-wrapper h-auto md:h-full">
                                @foreach ($product->variants as $variant)
                                    <div class="swiper-slide w-32 h-min md:h-36 aspect-square cursor-pointer">
                                        <img onclick="changeImage(this.src, this)" src="{{ asset($variant->image) }}"
                                            data-weight="{{ $variant->weight }}"
                                            class="w-full h-full object-cover sw-item rounded" />
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-button-next">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Product Details (dummy content) -->
                <div id="productDetailsSection"
                    class="w-full bg-white p-0 md:p-6 md:pt-0 pt-0 rounded shadow-none relative transition-all duration-300">
                    @include('frontend.partials._breadcrumbs')

                    <input type="hidden" id="pdpProductId" value={{$product->id}} />
                    <h2 class="text-md md:text-xl font-semibold" data-translate>{{ $product->name }}</h2>
                    {{-- <p class="mt-2 text-sm text-gray-600">From collection <span class="bg-black text-white px-2 py-1 rounded">Liora</span></p> --}}
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach ($product?->category?->subcategories as $subcategory)
                            <a data-translate
                                href="{{ route('subcategory.show', [$product?->category->slug, $subcategory->slug]) }}"
                                class="text-xs md:text-sm border border-black text-gray-600 px-2 py-1 rounded-full hover:bg-black hover:text-white transition-all duration-300">{{ $subcategory->name }}</a>
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
                            <div class=" overflow-y-auto overflow-x-auto">
                                @foreach ($product->variants as $index => $variant)
                                    <div onclick="changeImage('{{ asset($variant->image) }}', this)"
                                        data-image="{{ asset($variant->image) }}" data-weight="{{ $variant->weight }}"
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
                                                    data-price_rmb="{{ $variant->price_rmb }}"
                                                    data-min_order_qty="{{ $variant->min_order_qty }}">-</button>
                                                <span id="qty-{{ $index }}">0</span>
                                                <button class="qty-increase px-2 py-1 border rounded"
                                                    data-index="{{ $index }}" data-product_id="{{ $variant->id }}"
                                                    data-price="{{ $variant->price }}"
                                                    data-price_rmb="{{ $variant->price_rmb }}"
                                                    data-min_order_qty="{{ $variant->min_order_qty }}">+</button>
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
                            🛒 <span data-translate>ADD TO CART</span> <span id="cartTotal">(0 items - $0.00)</span>
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
                        @if($product->description)
                            <p class="text-sm text-gray-600 mt-2" data-translate>
                                {{$product->description}}
                            </p>
                        @else
                        <p class="text-sm text-gray-600 mt-2" data-translate>
                            "Our stainless steel jewelry is crafted from premium 304 and 316L corrosion-resistant stainless
                            steel, ensuring superior strength and longevity. Featuring a weatherproof finish and an
                            exquisite 18k gold plating, each piece combines luxury and durability with a sleek, modern
                            design, perfect for everyday wear or special occasions"
                        </p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <div class="border rounded-lg mb-3">
                            <!-- Header -->
                            <div class="bg-gray-100 px-4 py-2 flex justify-between items-center rounded-t-lg">
                                <span class="font-medium" data-translate>Description</span>
                                <button
                                    class="descToggle bg-black text-white w-6 h-6 flex items-center justify-center rounded">
                                    –
                                </button>
                            </div>

                            <!-- Content (first one visible) -->
                            <div class="descContent px-6 py-4 grid grid-cols-2 gap-y-1 text-sm">
                                <div data-translate>Quantity</div>
                                <div>12 Pcs</div>

                                <div class="font-medium" data-translate>Plating Material</div>
                                <div data-translate>18K Gold, Electroplating</div>

                                <div>Spu</div>
                                <div>{{ $product->sku }}</div>

                                <div data-translate>Classification</div>
                                <div data-translate>{{ $product->category->name }}</div>

                                <div data-translate>Style</div>
                                <div data-translate>Moderate Luxury</div>

                                <div data-translate>Material</div>
                                <div data-translate>Stainless Steel</div>

                                <div data-translate>Weight</div>
                                <div><span class="weight">{{ $product->variants->first()->weight }}</span>g</div>

                                <div data-translate>Occasion</div>
                                <div data-translate>Daily, Holiday, Wedding</div>

                                <div data-translate>Gender</div>
                                <div data-translate>{{ $product->gender }}</div>

                                <div data-translate>Pendant Material</div>
                                <div>Titanium Steel</div>
                            </div>
                        </div>

                        <div class="border rounded-lg mb-3">
                            <!-- Header -->
                            <div class="bg-gray-100 px-4 py-2 flex justify-between items-center rounded-t-lg">
                                <span class="font-medium" data-translate>Shipping Policy</span>
                                <button
                                    class="descToggle bg-black text-white w-6 h-6 flex items-center justify-center rounded">
                                    +
                                </button>
                            </div>

                            <!-- Content (hidden by default) -->
                            <div class="descContent p-2 grid grid-cols-2 gap-y-1 text-sm hidden">
                                @foreach (App\Models\ShippingPolicy::where('status', 1)->get() as $shipping_policy)
                                    <div class="p-2">
                                        <h3 class="text-sm font-semibold mb-2" data-translate>{{ $shipping_policy->title }}
                                        </h3>
                                        <div class="text-gray-700 prose" data-translate>
                                            {!! $shipping_policy->description !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col mt-12 gap-6">
                <h2 class="text-4xl">You may also like</h2>

                <div class="">
                    <div class="swiper productSwiper">
                        <div class="swiper-button-prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </div>
                        <div class="swiper-wrapper h-auto md:h-full">
                            @foreach ($products as $product)
                                <div class="swiper-slide w-m-32  cursor-pointer">
                                    @include('frontend.partials._product_card')
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-button-next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col mt-12 gap-6" id="recently-viewed">
                <h2 class="text-4xl">Recently Viewed</h2>

                <div>
                    <div class="swiper recentProductSwiper">
                        <div class="swiper-button-prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </div>
                        <div class="swiper-wrapper h-auto md:h-full" id="recent-products">
                            
                        </div>

                        <div class="swiper-button-next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('scripts')
    @include('frontend.pages.scripts.pdp_scripts')
@endsection
