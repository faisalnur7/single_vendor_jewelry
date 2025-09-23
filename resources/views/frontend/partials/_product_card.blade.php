<div class="flex flex-col product_card {{$opacityZero ?? ''}} transform transition-opacity duration-700">
    <a href="{{ route('show_product', $product->slug) }}">

        <!-- Image with overlay icons -->
        <div class="relative bg-white border rounded-none group overflow-hidden">
            <img loading="lazy" id="mainImage-{{ $product->id }}" src="{{ asset($product->image) }}" alt="Product Main"
                class="mx-auto transition-transform duration-[3000ms] group-hover:scale-[1.5] opacity-100 transition-opacity duration-500" />

            <!-- Icons (eye + heart) -->
            <div
                class="absolute bottom-2 left-1/2 -translate-x-1/2 transform flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">

                <!-- Eye icon -->
                <button
                    class="bg-white rounded-full shadow flex justify-center items-center w-12 h-12 transition-colors duration-300 hover:bg-black group/icon">
                    <i
                        class="fa-solid fa-eye text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                </button>

                <!-- Heart icon -->
                <button
                    class="wishlist_btn bg-white rounded-full shadow flex justify-center items-center w-12 h-12 transition-colors duration-300 hover:bg-black group/icon"
                    data-product_id="{{ $product->id }}">
                    <i
                        class="fa-regular fa-heart text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                </button>
            </div>
        </div>

        <!-- Product title -->
        <div
            class="text-sm overflow-hidden whitespace-nowrap text-ellipsis w-full max-w-full sm:max-w-[250px] md:max-w-[300px] lg:max-w-[350px] mt-2">
            <a href="#" class="block" data-translate>{{ $product->name }}</a>
        </div>

        <!-- Product price -->
        <div class="text-sm overflow-hidden text-ellipsis w-full max-w-full">
            {{-- <p class="text-xl md:text-lg font-semibold  text-gray-800">{{ show_price_range($product->variants) }}</p> --}}
            <p class="text-xl md:text-lg font-semibold text-gray-800">{{ $product->price_range }}</p>

        </div>

        <!-- Thumbnails -->
        @php
            $variantCount = $product->variants->count();

            $mobileShow = min(3, $variantCount); // mobile default <640px
            $smShow = min(3, $variantCount);
            $mdShow = min(3, $variantCount);
            $lgShow = min(3, $variantCount);
            $xlShow = min(3, $variantCount);
        @endphp

        <div class="flex space-x-1 my-2">
            @foreach ($product->variants as $index => $variant)
                <div
                    class="bg-white rounded-none overflow-hidden flex items-center justify-center
                    w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 flex-shrink-0

                    border group max-w-20
                    {{-- @if ($index >= $mobileShow)hidden @endif --}}
                    xl:@if ($index >= $xlShow) hidden @endif
                    lg:@if ($index >= $lgShow) hidden @endif
                    md:@if ($index >= $mdShow) hidden @endif
                    sm:@if ($index >= $smShow) hidden @endif
                    ">
                    <img src="{{ asset($variant->image) }}" alt="Product Variant"
                        class="variant-thumb max-w-full max-h-full object-cover cursor-pointer mx-auto transition-all duration-500 p-[1px] border-0 group-hover:bg-black"
                        data-main-image="mainImage-{{ $product->id }}"
                        data-variant-src="{{ asset($variant->image) }}" />
                </div>
            @endforeach

            @if ($variantCount > $mobileShow)
                <a href="{{ route('show_product', $product->slug) }}">
                    <div
                        class="bg-gray-100 border rounded-none overflow-hidden w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-semibold text-gray-600">
                            +{{ $variantCount - $mobileShow }}
                        </span>
                    </div>
                </a>
            @endif
        </div>
    </a>
</div>
