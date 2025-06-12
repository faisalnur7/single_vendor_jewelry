<nav class="text-md text-gray-600 mt-6 ml-6" aria-label="Breadcrumb">
  <ol class="list-reset flex flex-wrap space-x-2">
    <li>
      <a href="{{ url('/') }}" class="hover:underline">Home</a>
    </li>
    <li>/</li>
    <li>
        <a href="#" class="hover:underline">
          Collections
        </a>
      </li>
    @isset($category)
      <li>/</li>
      <li>
        <a href="{{ route('category.show', $category->slug) }}" class="hover:underline">
          {{ $category->name }}
        </a>
      </li>
    @endisset

    @isset($subcategory)
      <li>/</li>
      <li>
        <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}" class="hover:underline">
          {{ $subcategory->name }}
        </a>
      </li>
    @endisset

    @isset($product)
      <li>/</li>
      <li class="text-gray-500">
        {{ $product->name }}
      </li>
    @endisset
  </ol>
  <h2 class="mt-6 text-3xl font-bold">Collections</h2>
</nav>
