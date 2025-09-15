<nav class="text-xs md:text-md text-gray-600 m-0" aria-label="Breadcrumb">
    <div class="space-x-2">
        <span>
            <a href="{{ url('/') }}" class="hover:underline" data-translate>Home</a>
        </span>
        @isset($category)
            <span>/</span>
            <span>
                <a href="{{ route('category.show', $category->slug) }}"
                    class="hover:underline @if (isset($category_bold)) text-gray-800 font-bold @endif"  data-translate>
                    {{ $category->name }}
                </a>
            </span>
        @endisset

        @isset($subcategory)
            <span>/</span>
            <span>
                <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}"
                    class="hover:underline @if (isset($subcategory_bold)) text-gray-800 font-bold @endif"  data-translate>
                    {{ $subcategory->name }}
                </a>
            </span>
        @endisset

        @isset($childsubcategory)
            <span>/</span>
            <span>
                <a href="{{ route('childsubcategory.show', [$category->slug, $subcategory->slug, $childsubcategory->slug]) }}"
                    class="hover:underline @if (isset($childsubcategory_bold)) text-gray-800 font-bold @endif"  data-translate>
                    {{ $childsubcategory->name }}
                </a>
            </span>
        @endisset

        @isset($product)
            <span>/</span>
            <span class="text-gray-800" data-translate>
                {{ $product->name }}
            </span>
        @endisset
    </div>
    @isset($page_title)
        <h2 class="mt-6 text-3xl font-bold text-black">{{ $page_title }}</h2>
    @endisset
</nav>
