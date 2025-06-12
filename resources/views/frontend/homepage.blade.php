@extends('frontend.layouts.main')

@section('contents')
    <!-- Hero Section -->
    <section class="bg-beige text-center bg-gradient-to-br from-amber-100 to-white">
        @include('frontend.partials._banner')
    </section>

    <!-- Product Section -->
    <section class="py-12 px-6">
        <h2 class="text-4xl font-bold text-center mb-8">Wholesale Trending Discovery</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-3 gap-6">
            @for ($i = 0; $i < 6; $i++)
                @include('frontend.partials._trending_card')
            @endfor
        </div>
    </section>

    <!-- Featured Categories Section -->
    <section class="py-12 px-6">
        <h2 class="text-4xl font-bold text-center mb-8">Featured Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-2">
            @for ($i = 0; $i < 16; $i++)
                @include('frontend.partials._featured_category_card')
            @endfor
        </div>
    </section>

    <!-- Products you may like Section -->
    <section class="py-12 px-6">
        <h2 class="text-4xl font-bold text-center mb-8">Products You May Like</h2>
        <div class="flex justify-center gap-6 pb-8">
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Best Sellers</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Party</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Summer</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Sunflower</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Cross Neckleaces</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Bow</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Moon</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Sun</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Heart</a>
            <a href="#" class="flex hover:text-blue-600 text-blue-900 text-lg">Hair Accessories</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2">
            @foreach ($products as $product)
                @include('frontend.partials._product_card')
            @endforeach
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            //effect: 'fade',
            //fadeEffect: {
            //  crossFade: true,
            // },
            autoplay: {
                delay: 3000,
                //disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endsection
