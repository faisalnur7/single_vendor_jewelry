@php
    $mayLikedCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::MAY_LIKED)
        ->orderBy('order', 'asc')
        ->get();
    $mayLikedCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::FEATURED)
        ->orderBy('order', 'asc')
        ->get();
    $mayLikedCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::TRENDING)
        ->orderBy('order', 'asc')
        ->get();

    $onLoadProducts = collect([]);

    if ($selectedCategory = $mayLikedCategories->first()) {
        // Determine the most specific column and ID to use
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

        // Fetch products only once
        $onLoadProducts = \App\Models\Product::where($column, $id)->take(20)->get();
    }

@endphp
<div class="flex gap-10 w-full flex-col">
    <div class="flex gap-10 w-full justify-center mx-auto may_like_menu">
        @foreach ($mayLikedCategories as $mayLikedCategory)
            @php
                $productsCount = 0;
                $route = '#';
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
                } elseif (!empty($mayLikedCategory->sub_category_id)) {
                    $productsCount = \App\Models\Product::where(
                        'sub_category_id',
                        $mayLikedCategory->sub_category_id,
                    )->count();
                    $route = route('homePageProducts', ['subcategory' => $subCategorySlug]);
                    $categoryType = 'subcategory';
                } elseif (!empty($mayLikedCategory->category_id)) {
                    $productsCount = \App\Models\Product::where('category_id', $mayLikedCategory->category_id)->count();
                    $route = route('homePageProducts', ['category' => $categorySlug]);
                    $categoryType = 'category';
                }
            @endphp

            @if ($productsCount > 0)
                <div>
                    <div class="flex flex-col items-center text-center mt-6">
                        <p class="mt-2 text-md cursor-pointer may_like_menu_item"
                            data-url="{{ $route }}" data-type="{{ $categoryType }}">
                            {{ $mayLikedCategory->name }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach

    </div>


    <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 relative">
        <!-- Loader -->
        <div id="productLoader" class="absolute inset-0 flex justify-center items-center bg-white bg-opacity-70 hidden z-10">
            <img src="{{asset('/infinity_loader_blue.gif')}}" />
        </div>

        @foreach ($onLoadProducts as $product)
            <div class="product_card opacity-0 transform translate-y-4 transition-all duration-500">
                @include('frontend.partials._product_card')
            </div>
        @endforeach
    </div>

</div>
<script>
$(document).ready(function() {
    // Initially highlight first menu item
    $('.may_like_menu_item').first().addClass('text-blue-600');

    function fadeInProducts() {
        $('#productContainer .product_card').each(function(index) {
            $(this).delay(index * 100).queue(function(next) {
                $(this).removeClass('opacity-0 translate-y-4');
                next();
            });
        });
    }

    fadeInProducts(); // Fade-in on initial load

    $('.may_like_menu_item').on('click', function() {
        var $this = $(this);
        var url = $this.data('url');

        // Highlight menu
        $('.may_like_menu_item').removeClass('text-blue-600');
        $this.addClass('text-blue-600');

        // Show loader
        $('#productLoader').removeClass('hidden');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Replace products
                $('#productContainer').html(response);

                // Hide loader
                $('#productLoader').addClass('hidden');

                // Add animation classes to new products
                $('#productContainer .product_card').addClass('opacity-0 translate-y-4');
                fadeInProducts();
            },
            error: function(xhr) {
                console.error('Error fetching products:', xhr);
                $('#productLoader').addClass('hidden');
            }
        });
    });
});
</script>
