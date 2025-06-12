<!-- Slider main container -->
<div class="swiper group relative">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        @for ($i = 0; $i < 9; $i++)
            @include('frontend.partials._banner_slides')
        @endfor
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <!-- Navigation buttons -->
    <div class="swiper-button-prev opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-6 h-6 text-sm  text-white rounded-full flex items-center justify-center absolute top-1/2 -translate-y-1/2 left-2 z-10"></div>
    <div class="swiper-button-next opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-6 h-6 text-sm  text-white rounded-full flex items-center justify-center absolute top-1/2 -translate-y-1/2 right-2 z-10"></div>

</div>
