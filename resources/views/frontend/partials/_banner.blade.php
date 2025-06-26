@php
    $sliderImages = [
        '//factorypricejewelry.com/cdn/shop/files/6.23sale.png?v=1750664889&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/6.4banner_9a111e6a-38f6-4795-a900-0255335770cf.png?v=1749434529&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/17_8ec839ea-4294-41aa-a579-cd29ad84af76.png?v=1749434539&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/9_9b275207-d4b4-45cc-ac77-97ee8ab06fd0.png?v=1747811390&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/11_57928ae4-857e-44fd-a477-c87e03125347.png?v=1747811355&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/3_2f4ab8d0-10b6-408f-90c6-8160bfd0301a.png?v=1739417734&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/4.png?v=1739417737&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/2_885dbd0b-0a05-4588-9ea2-b3ec0e3b5b3d.png?v=1739417730&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/Factory_Price_Jewellery_Option_9.png?v=1712276126&width=3000',
        '//factorypricejewelry.com/cdn/shop/files/Factory_Price_New_Banner_2Artboard-1.png?v=1711075649&width=3000',
    ];
@endphp

<!-- Slider main container -->
<div class="swiper group relative">
    <!-- Wrapper -->
    <div class="swiper-wrapper">
        @foreach ($sliderImages as $index => $img)
            <div class="swiper-slide">
                <img src="{{ $img }}" alt="Slide {{ $index + 1 }}" loading="lazy"
                    class="w-full h-[700px] object-cover" />
            </div>
        @endforeach
    </div>


    <!-- Pagination -->
    <div class="swiper-pagination"></div>

    <!-- Navigation Buttons -->
    <div
        class="swiper-button-prev opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-6 h-6 text-sm text-white rounded-full flex items-center justify-center absolute top-1/2 -translate-y-1/2 left-2 z-10">
    </div>
    <div
        class="swiper-button-next opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-6 h-6 text-sm text-white rounded-full flex items-center justify-center absolute top-1/2 -translate-y-1/2 right-2 z-10">
    </div>
</div>
