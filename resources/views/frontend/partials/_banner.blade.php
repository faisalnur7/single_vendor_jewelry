@php
    $banners = App\Models\HomepageBanner::query()->where('status','1')->get();
@endphp

<!-- Slider main container -->
<div class="swiper group relative">
    <!-- Wrapper -->
    <div class="swiper-wrapper">
        @foreach ($banners as $index => $banner)
            @php
                $route = "#";
                if(!empty($banner->child_sub_category_id)){
                    $route = route('childsubcategory.show', [$banner->category->slug, $banner->subCategory->slug, $banner->childSubCategory->slug]);
                }else if(!empty($banner->sub_category_id)){
                    $route = route('subcategory.show', [$banner->category->slug, $banner->subCategory->slug]);
                }else if(!empty($banner->category_id)){
                    $route = route('category.show', $banner->category->slug);
                }
            @endphp
            <div class="swiper-slide">
                <a href="{{$route}}">
                    <img src="{{ $banner->banner }}" alt="Slide {{ $index + 1 }}" loading="lazy" class="w-full h-550px] object-contain" />
                </a>
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
