<nav class="text-md text-gray-600 mt-6 ml-6" aria-label="Breadcrumb">
    <ol class="list-reset flex flex-wrap space-x-2">
        <li>
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
        </li>
        @isset($category)
            <li>/</li>
            <li>
                <a href="{{ route('category.show', $category->slug) }}"
                    class="hover:underline @if (isset($category_bold)) text-gray-800 font-bold @endif">
                    {{ $category->name }}
                </a>
            </li>
        @endisset

        @isset($subcategory)
            <li>/</li>
            <li>
                <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}"
                    class="hover:underline @if (isset($subcategory_bold)) text-gray-800 font-bold @endif">
                    {{ $subcategory->name }}
                </a>
            </li>
        @endisset

        @isset($childsubcategory)
            <li>/</li>
            <li>
                <a href="{{ route('childsubcategory.show', [$category->slug, $subcategory->slug, $childsubcategory->slug]) }}"
                    class="hover:underline @if (isset($childsubcategory_bold)) text-gray-800 font-bold @endif">
                    {{ $childsubcategory->name }}
                </a>
            </li>
        @endisset

        @isset($product)
            <li>/</li>
            <li class="text-gray-800 font-bold">
                {{ $product->name }}
            </li>
        @endisset
    </ol>
    @isset($page_title)
        <h2 class="mt-6 text-3xl font-bold">{{ $page_title }}</h2>
    @endisset
</nav>
