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
    <!-- Products you may like Section -->
    <section class="py-12 px-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
            @foreach ($products as $product)
                @include('frontend.partials._product_card')
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $products->links('vendor.pagination.circle', ['paginator' => $products]) }}
        </div>

    </section>

@endsection
