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
        <form method="GET" id="sortForm" class="min-w-44">
            <select name="sort_by" class="border border-gray-300 rounded-md px-3 py-2 text-md w-full"
                onchange="document.getElementById('sortForm').submit();">
                <option value="manual" {{ request('sort_by') == 'manual' ? 'selected' : '' }}>Featured</option>
                <option value="price-ascending" {{ request('sort_by') == 'price-ascending' ? 'selected' : '' }}>Price, low to
                    high</option>
                <option value="price-descending" {{ request('sort_by') == 'price-descending' ? 'selected' : '' }}>Price,
                    high to low</option>
            </select>
        </form>
    </div>



    <!-- Products you may like Section -->
    <section class="pt-3 pb-12 px-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
            @foreach ($products as $product)
                @include('frontend.partials._product_card')
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $products->appends(request()->query())->links('vendor.pagination.circle') }}

        </div>

    </section>

@endsection
