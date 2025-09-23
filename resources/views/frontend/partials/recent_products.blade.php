    @foreach ($products as $product)
        <div class="swiper-slide w-m-32  cursor-pointer">
            @include('frontend.partials._product_card')
        </div>
    @endforeach
