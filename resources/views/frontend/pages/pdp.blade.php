@extends('frontend.layouts.main')
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
    </style>
@endsection
@section('contents')
    @include('frontend.partials._breadcrumbs')
    <section class="pt-0 pb-12 px-6">
        <div class="mx-auto p-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Image Viewer -->
                <div>
                    <div class=" flex gap-4">
                        <!-- Main Image Full Width, Natural Height -->
                        <div class="relative border rounded overflow-hidden w-full">
                            <img id="mainImage" src="{{ asset($product->image) }}"
                                class="w-full h-auto object-contain transition-opacity duration-300 opacity-100" />
                            <div id="lens"
                                class="absolute pointer-events-none border border-gray-400 bg-white bg-opacity-40 rounded hidden">
                            </div>
                        </div>

                        <!-- Zoom Preview -->
                        <div id="zoomWrapper"
                            class="absolute left-full top-0 ml-6 w-[400px] h-[400px] border overflow-hidden rounded shadow-xl hidden z-[999999] bg-white">
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
                                        <img onclick="changeImage(this.src)" src="{{ asset($variant->image) }}"
                                            class="w-full border rounded" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details (dummy content) -->
                <div class="w-full bg-white p-6 pt-0 rounded shadow-none">
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    {{-- <p class="mt-2 text-sm text-gray-600">From collection <span class="bg-black text-white px-2 py-1 rounded">Liora</span></p> --}}

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="text-xs border px-2 py-1 rounded-full">Fall & Winter Jewelry</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Gold Plated Jewelry</span>
                        <span class="text-xs border px-2 py-1 rounded-full">IHeart Collection</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Luxury Jewelry</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Stainless Steel Heart</span>
                        <span class="text-xs border px-2 py-1 rounded-full">Water-Resistant Jewelry</span>
                    </div>


                    <!-- Price Range -->
                    <p class="text-2xl font-semibold my-4">${{ $product->variants->min('price') }} -
                        ${{ $product->variants->max('price') }}</p>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <div class="w-full border-gray-200 text-sm">
                            <!-- Header Row -->
                            <div class="grid grid-cols-3 bg-gray-100 text-gray-700 font-bold">
                                <div class="p-2">Color</div>
                                <div class="p-2">Price</div>
                                <div class="p-2 text-center">Qty</div>
                            </div>

                            <!-- Data Rows -->
                            <div class="max-h-[500px] overflow-y-auto">
                                @foreach ($product->variants as $index => $variant)
                                    <div onclick="changeImage('{{ asset($variant->image) }}', this)"
                                        data-image="{{ asset($variant->image) }}"
                                        class="grid grid-cols-3 items-center mt-1  border border-gray-300 variant_row hover:bg-gray-50 hover:border-black cursor-pointer ">
                                        <!-- Color + Image -->
                                        <div class="p-2 flex items-center gap-2">
                                            <img src="{{ asset($variant->image) }}"
                                                class="w-12 h-12 object-cover  rounded" />
                                            <span>{{ $variant->color }}</span>
                                        </div>

                                        <!-- Price -->
                                        <div class="p-2 font-semibold">${{ $variant->price }}</div>

                                        <!-- Quantity Controls -->
                                        <!-- Quantity Controls -->
                                        <div class="p-2 flex justify-center text-center">
                                            <div class="flex items-center justify-center gap-2 pdp_quantity">
                                                <button class="qty-decrease px-2 py-1 border rounded"
                                                    data-index="{{ $index }}"
                                                    data-product_id="{{$variant->id}}"
                                                    data-price="{{ $variant->price }}">-</button>
                                                <span id="qty-{{ $index }}">0</span>
                                                <button class="qty-increase px-2 py-1 border rounded"
                                                    data-index="{{ $index }}"
                                                    data-product_id="{{$variant->id}}"
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
                        <button class="border p-3 rounded-md border-gray-800 text-black wishlist_btn">
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
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2">
                            <li>Material: Stainless Steel</li>
                            <li>Plating: 18K Gold</li>
                            <li>Water-Resistant: Yes</li>
                            <li>Hypoallergenic: Yes</li>
                            <li>Dimensions: Adjustable chain length</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(function() {
            // Swiper initialization
            new Swiper('.thumbnailSwiper', {
                slidesPerView: 5,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });

            const $img = $("#mainImage");
            const $lens = $("#lens");
            const $result = $("#result");
            const $zoomWrapper = $("#zoomWrapper");

            const zoom = 3;

            // Mouse enter
            $img.on("mouseenter", function() {
                $lens.show();
                $zoomWrapper.show();
                $result.css("background-image", `url('${$img.attr("src")}')`);
            });

            // Mouse leave
            $img.on("mouseleave", function() {
                $lens.hide();
                $zoomWrapper.hide();
            });

            // Mouse move
            $img.on("mousemove", function(e) {
                const bounds = $img[0].getBoundingClientRect();
                const lensWidth = $result.outerWidth() / zoom;
                const lensHeight = $result.outerHeight() / zoom;

                $lens.css({
                    width: lensWidth + "px",
                    height: lensHeight + "px",
                });

                let x = e.clientX - bounds.left - lensWidth / 2;
                let y = e.clientY - bounds.top - lensHeight / 2;

                x = Math.max(0, Math.min(x, bounds.width - lensWidth));
                y = Math.max(0, Math.min(y, bounds.height - lensHeight));

                $lens.css({
                    left: x + "px",
                    top: y + "px",
                });

                const ratioX = $img[0].naturalWidth / $img.width();
                const ratioY = $img[0].naturalHeight / $img.height();

                const bgPosX = x * ratioX;
                const bgPosY = y * ratioY;

                $result.css({
                    "background-size": `${$img[0].naturalWidth * zoom}px ${$img[0].naturalHeight * zoom}px`,
                    "background-position": `-${bgPosX * zoom}px -${bgPosY * zoom}px`,
                });
            });

            // Change image function for variant rows or thumbnails
            window.changeImage = function(src, el = null) {
                const $img = $("#mainImage");
                const $result = $("#result");

                // Update the selected row style
                $(".variant_row").removeClass("border-gray-700");
                if (el) {
                    $(el).addClass("border-gray-700");
                }

                // Fade out current image
                $img.removeClass("opacity-100").addClass("opacity-0");

                setTimeout(() => {
                    $img.attr("src", src);
                    $img.on("load", function() {
                        $img.removeClass("opacity-0").addClass("opacity-100");
                        $result.css("background-image", `url('${src}')`);
                    });
                }, 200);
            };

            $(document).on("mouseenter", ".wishlist_btn", function() {
                $(this).find('.heart_icon').removeClass("fa-regular").addClass("fa-solid");
            });

            $(document).on("mouseleave", ".wishlist_btn", function() {
                $(this).find('.heart_icon').removeClass("fa-solid").addClass("fa-regular");
            });

            function updateCartTotal() {
                let totalItems = 0;
                let totalPrice = 0;

                $('[id^="qty-"]').each(function() {
                    let qty = parseInt($(this).text());
                    if (qty > 0) {
                        let index = $(this).attr('id').split('-')[1];
                        let price = parseFloat($('[data-index="' + index + '"]').first().data('price'));
                        totalItems += qty;
                        totalPrice += qty * price;
                    }
                });

                $('#cartTotal').text(`(${totalItems} items - $${totalPrice.toFixed(2)})`);
            }

            $('.qty-increase').click(function() {
                var index = $(this).data('index');
                var qtyElem = $('#qty-' + index);
                var current = parseInt(qtyElem.text());
                qtyElem.text(current + 1);
                updateCartTotal();
            });

            $('.qty-decrease').click(function() {
                var index = $(this).data('index');
                var qtyElem = $('#qty-' + index);
                var current = parseInt(qtyElem.text());
                if (current > 0) {
                    qtyElem.text(current - 1);
                    updateCartTotal();
                }
            });

            $('.add_to_cart_btn').click(function() {
                const itemsToAdd = [];

                $('[id^="qty-"]').each(function() {
                    const qty = parseInt($(this).text());
                    if (qty > 0) {
                        const index = $(this).attr('id').split('-')[1];
                        const price = $('[data-index="' + index + '"]').first().data('price');
                        const productId = $('[data-index="' + index + '"]').first().data('product_id'); // assuming you have this
                        const variant = @json($product->variants);

                        itemsToAdd.push({
                            product_id: productId,
                            variant_index: index,
                            quantity: qty,
                            price: price
                        });
                    }
                });

                if (itemsToAdd.length === 0) {
                    alert("Please select at least one item.");
                    return;
                }

                // Send one by one — or batch if you create such backend support

                    $.ajax({
                        url: "{{ route('add_to_cart') }}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            items: itemsToAdd
                        },
                        success: function(res) {
                            console.log(res);
                            if (res.success) {
                                // Optional: show a toast or update top cart HTML
                            }
                        },
                        error: function(err) {
                            if (err.status === 401) {
                                alert('Please login to add items to cart.');
                                window.location.href = '/login';
                            } else {
                                alert('Failed to add item to cart.');
                            }
                        }
                    });
                });

        });
    </script>
@endsection
