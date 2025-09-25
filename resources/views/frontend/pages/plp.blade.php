@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('styles')
    <style>
        /* put this in your stylesheet or inside a <style> tag */
        .product-main-img {
            transition: transform 200ms ease;
            transform-origin: center center;
            will-change: transform;
        }
    </style>
@endsection
@section('contents')
    <div class="ml-6 mt-4 !text-md">
        @include('frontend.partials._breadcrumbs')
    </div>
    <div class="flex flex-row md:flex-row items-center justify-between mt-6 mb-2 px-6">
        <!-- Title -->
        <h1 class="text-xl md:text-4xl mb-2 md:mb-0">
            {{ $title }}
        </h1>

        <!-- Sort dropdown -->
        <form method="GET" id="sortForm" class="md:min-w-44">
            <select name="sort_by" id="sortDropdown" class="border border-gray-300 rounded-md px-3 py-2 text-md w-full">
                <option value="manual" {{ request('sort_by') == 'manual' ? 'selected' : '' }}>Featured</option>
                <option value="price-ascending" {{ request('sort_by') == 'price-ascending' ? 'selected' : '' }}>Price, low
                    to high</option>
                <option value="price-descending" {{ request('sort_by') == 'price-descending' ? 'selected' : '' }}>Price,
                    high to low</option>
            </select>
        </form>

    </div>



    <!-- Products you may like Section -->
    <section class="pt-3 pb-12 px-6">
        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
            @foreach ($products as $product)
                @include('frontend.partials._product_card')
            @endforeach
        </div>

        <div id="loader" class="text-center py-4 flex hidden justify-center">
            <img src="{{ asset('/infinity_loader_blue.gif') }}" />
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let page = 1;
            let loading = false;
            let lastPage = {{ $products->lastPage() }};

            // Function to fade in products
            function fadeInProducts($products) {
                $products.each(function(index) {
                    $(this).delay(index * 40).queue(function(next) {
                        $(this).removeClass('opacity-0');
                        next();
                    });
                });
            }

            function loadProducts(pageNumber, append = true) {
                if (loading) return;
                loading = true;
                $('#loader').removeClass('hidden');

                let sortBy = $('#sortDropdown').val();
                let url = "{{ request()->url() }}?page=" + pageNumber + "&sort_by=" + sortBy;

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        let $newProducts = $(response.html).addClass('opacity-0'); // initially hidden

                        if (append) {
                            $('#productContainer').append($newProducts);
                        } else {
                            $('#productContainer').html($newProducts);
                            page = 1; // reset page counter
                        }

                        // Fade in effect
                        fadeInProducts($newProducts);

                        // Update lastPage dynamically
                        lastPage = response.lastPage;

                        loading = false;
                        $('#loader').addClass('hidden');
                    },
                    error: function(err) {
                        console.error(err);
                        loading = false;
                        $('#loader').addClass('hidden');
                    }
                });
            }

            // Infinite scroll
            $(window).on('scroll', function() {
                let scrollPosition = $(window).scrollTop() + $(window).height();
                let threshold = $(document).height() - 200;

                if (scrollPosition >= threshold && !loading) {
                    page++;
                    if (page > lastPage) return;
                    loadProducts(page);
                }
            });

            // Sort change event
            $('#sortDropdown').on('change', function() {
                page = 1;
                loadProducts(1, false); // replace content
            });

            // Initial fade-in for first load
            fadeInProducts($('.product_card'));
        });
    </script>
@endsection
