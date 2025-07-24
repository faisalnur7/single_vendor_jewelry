@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('contents')
    <!-- Hero Section -->
    <section class="bg-beige text-center bg-gradient-to-br from-amber-100 to-white">
        @include('frontend.partials._banner')
    </section>

    <!-- Product Section -->
    <section class="py-12 px-6">
        <h2 class="text-4xl font-bold text-center mb-8">Wholesale Trending Discovery</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-3 gap-6">
            @include('frontend.partials._trending_card')
        </div>
    </section>

    <!-- Featured Categories Section -->
    <section class="py-12 px-6">
        <h2 class="text-4xl font-bold text-center mb-8">Featured Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-2">
            @include('frontend.partials._featured_category_card')
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
    

    <section class="py-6 px-6 min-h-[600px] bg-cover bg-center bg-no-repeat" style="background-image: url('/assets/img/images/why_choose_us.webp')">
        <div class="flex w-full bg-transparent py-6 rounded">
            <div class="w-1/2">
                <h2 class="text-5xl font-bold mb-6">Why Choose Us</h2>
                <div class="why_choose_us_list">
                    {!! $homepage_setting->why_choose_us !!}
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 py-6 px-6 min-h-[600px] bg-cover bg-center bg-no-repeat" style="background-image: url('/assets/img/images/about_stainless.webp')">
        <div class="flex w-full bg-transparent py-6 rounded">
            <div class="w-1/2"></div>
            <div class="w-1/2">
                <div class="why_choose_us_list">
                    {!! $homepage_setting->about !!}

                    <div class="max-w-md mt-6 grid gap-4">
                        <button class="bg-black text-white py-3 text-sm tracking-widest uppercase transition duration-500 hover:bg-gray-700 hover:text-white">Learn More About Us</button>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{route('signup')}}" class="border border-black py-2 text-sm tracking-wider uppercase transition duration-500 hover:bg-black hover:text-white justify-center flex items-center">Register</a>
                            <a href="{{route('signin')}}" class="border border-black py-2 text-sm tracking-wider uppercase transition duration-500 hover:bg-black hover:text-white justify-center flex items-center">Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6 px-6">
        <div class="flex w-full bg-transparent py-6 rounded">
            <div class="w-full">
                <div class="down_paragraph">
                    {!! $homepage_setting->down_paragraph !!}
                </div>
            </div>
        </div>
    </section>



@endsection
@section('scripts')
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true,
            },
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
