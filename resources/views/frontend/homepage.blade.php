@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('contents')
    <!-- Hero Section -->
    <section class="bg-beige text-center bg-gradient-to-br from-amber-100 to-white">
        @include('frontend.partials._banner')
    </section>

    <!-- Product Section -->
    <section class="py-12 px-6">
        <h2 class="text-5xl text-center mb-8 font-semibold not-italic antialiased tracking-[0.16px] text-black">Wholesale Trending Discovery</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-3 gap-6">
            @include('frontend.partials._trending_card')
        </div>
    </section>

    <!-- Featured Categories Section -->
    <section class="py-12 px-6">
        <h2 class="text-5xl text-center mb-8 font-semibold not-italic antialiased tracking-[0.16px] text-black">Featured Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-2">
            @include('frontend.partials._featured_category_card')
        </div>
    </section>

    <!-- Product You May Like Section -->
    <section class="py-12 px-6">
        <h2 class="text-5xl text-center mb-6 font-semibold not-italic antialiased tracking-[0.16px] text-black">Products You May Like</h2>
        @include('frontend.partials._product_may_like_card')
    </section>

    <section class="py-6 px-6 min-h-[600px] bg-cover md:bg-center bg-no-repeat" style="background-image: url('/assets/img/images/why_choose_us.webp')">
        <div class="flex w-full bg-transparent py-6 rounded">
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl  md:text-5xl font-bold mb-6">Why Choose Us</h2>
                <div class="why_choose_us_list">
                    {!! $homepage_setting->why_choose_us !!}
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 py-6 px-6 min-h-[600px] bg-cover bg-right md:bg-center bg-no-repeat" style="background-image: url('/assets/img/images/about_stainless.webp')">
        <div class="flex w-full bg-transparent py-6 rounded">
            <div class="w-1/2"></div>
            <div class="w-1/2">
                <div class="why_choose_us_list">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">Welcome to Stainless Steel Jewellery</h2>
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
            effect: 'slide',
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
