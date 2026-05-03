@php
    $mayLikedCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::MAY_LIKED)
        ->orderBy('order', 'asc')
        ->get();

    // Fallback: if no MAY_LIKED categories exist, use TRENDING then FEATURED
    if ($mayLikedCategories->isEmpty()) {
        $mayLikedCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::TRENDING)
            ->orderBy('order', 'asc')
            ->get();
    }
    if ($mayLikedCategories->isEmpty()) {
        $mayLikedCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::FEATURED)
            ->orderBy('order', 'asc')
            ->get();
    }

    $onLoadProducts = collect([]);
    $limit = 15;

    if ($selectedCategory = $mayLikedCategories->first()) {
        if (!empty($selectedCategory->child_sub_category_id)) {
            $column = 'child_sub_category_id';
            $id = $selectedCategory->child_sub_category_id;
        } elseif (!empty($selectedCategory->sub_category_id)) {
            $column = 'sub_category_id';
            $id = $selectedCategory->sub_category_id;
        } else {
            $column = 'category_id';
            $id = $selectedCategory->category_id;
        }

        $onLoadProducts = \App\Models\Product::with('variants')->where($column, $id)->take($limit)->get();
        $onLoadProducts->each(fn($p) => $p->price_range = show_price_range($p->variants));
    }
@endphp
<div class="flex gap-10 w-full flex-col">
    <div class="flex gap-10 w-full justify-center mx-auto may_like_menu">
        @foreach ($mayLikedCategories as $mayLikedCategory)
            @php
                $productsCount = 0;
                $route = '#';
                $page_route = '#';
                $categoryType = 'category';
                $categorySlug = $mayLikedCategory->category->slug ?? null;
                $subCategorySlug = $mayLikedCategory->subCategory->slug ?? null;
                $childCategorySlug = $mayLikedCategory->childSubCategory->slug ?? null;

                if (!empty($mayLikedCategory->child_sub_category_id)) {
                    $productsCount = \App\Models\Product::where(
                        'child_sub_category_id',
                        $mayLikedCategory->child_sub_category_id,
                    )->count();
                    $route = route('homePageProducts', ['childsubcategory' => $childCategorySlug]);
                    $categoryType = 'childsubcategory';
                    $page_route = route('subcategory.show', [$categorySlug, $subCategorySlug, $childCategorySlug]);
                } elseif (!empty($mayLikedCategory->sub_category_id)) {
                    $productsCount = \App\Models\Product::where(
                        'sub_category_id',
                        $mayLikedCategory->sub_category_id,
                    )->count();
                    $route = route('homePageProducts', ['subcategory' => $subCategorySlug]);
                    $categoryType = 'subcategory';
                    $page_route = route('subcategory.show', [$categorySlug, $subCategorySlug]);
                } elseif (!empty($mayLikedCategory->category_id)) {
                    $productsCount = \App\Models\Product::where('category_id', $mayLikedCategory->category_id)->count();
                    $route = route('homePageProducts', ['category' => $categorySlug]);
                    $categoryType = 'category';
                    $page_route = route('category.show',$categorySlug);
                }
            @endphp

            @if ($productsCount > 0)
                <div>
                    <div class="flex flex-col items-center text-center mt-6">
                        <p class="mt-2 text-md cursor-pointer may_like_menu_item" data-url="{{ $route }}" data-page_url="{{$page_route}}"
                            data-type="{{ $categoryType }}">
                            {{ $mayLikedCategory->name }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach

    </div>


    <div class="relative">
        <!-- Loader: outside productContainer so it survives html() replacement -->
        <div id="productLoader"
            class="absolute inset-0 flex justify-center items-center bg-white bg-opacity-70 hidden z-10">
            <img src="{{ asset('/infinity_transparent.gif') }}" />
        </div>

        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
            @foreach ($onLoadProducts as $product)
                @php $opacityZero = ''; @endphp
                @include('frontend.partials._product_card')
            @endforeach
        </div>
    </div>
    <div class="flex mx-auto w-full justify-center my-8">
        <a href="" class="btn btn-dark btn-lg" id="view_more_button">View More</a>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.may_like_menu_item').first().addClass('text-blue-600');
        $('#view_more_button').prop('href', $('.may_like_menu_item').first().data('page_url'));

        function fadeInProducts($cards, callback) {
            $cards.each(function(index) {
                var el = this;
                setTimeout(function() {
                    $(el).removeClass('opacity-0 translate-y-4');
                    if (index === $cards.length - 1 && typeof callback === 'function') callback();
                }, index * 80);
            });
        }

        var $initial = $('#productContainer .product_card');
        $initial.addClass('opacity-0 translate-y-4');
        fadeInProducts($initial);

        $(document).on('click', '.may_like_menu_item', function() {
            var $this = $(this);
            $('.may_like_menu_item').removeClass('text-blue-600');
            $this.addClass('text-blue-600');
            $('#view_more_button').prop('href', $this.data('page_url'));
            $('#productLoader').removeClass('hidden');

            $.ajax({
                url: $this.data('url'),
                type: 'GET',
                success: function(response) {
                    $('#productContainer').html(response);
                    var $cards = $('#productContainer .product_card').addClass('opacity-0 translate-y-4');
                    fadeInProducts($cards, function() {
                        $('#productLoader').addClass('hidden');
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching products:', xhr);
                    $('#productLoader').addClass('hidden');
                }
            });
        });
    });
</script>
