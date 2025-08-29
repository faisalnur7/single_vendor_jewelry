@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('contents')
<div class="container mx-auto px-4 py-8">

    <!-- Page Heading -->
    <h1 class="text-2xl font-semibold mb-4">
        Search results for: <span class="text-blue-600">{{ $keyword }}</span>
    </h1>

    <p class="py-4">Total products found : {{$product_count}}</p>

    <!-- No results message -->
    @if($products->count() == 0)
        <p class="text-gray-500">No products found for "{{ $keyword }}"</p>
    @endif

    <!-- Products Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($products as $product)
            <div class="flex flex-col product_card">
                <a href="{{ route('show_product', $product->slug) }}">
                    <!-- Image with overlay icons -->
                    <div class="relative bg-white border rounded-none group overflow-hidden">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                            class="mx-auto transition-transform duration-[3000ms] group-hover:scale-[1.5]" />

                        <!-- Icons (eye + heart) -->
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 transform flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <!-- Eye icon -->
                            <button class="bg-white rounded-full shadow flex justify-center items-center w-12 h-12 transition-colors duration-300 hover:bg-black group/icon">
                                <i class="fa-solid fa-eye text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                            </button>

                            <!-- Heart icon -->
                            <button class="wishlist_btn bg-white rounded-full shadow flex justify-center items-center w-12 h-12 transition-colors duration-300 hover:bg-black group/icon" data-product_id="{{ $product->id }}">
                                <i class="fa-regular fa-heart text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Product title -->
                    <div class="text-md overflow-hidden whitespace-nowrap text-ellipsis w-full max-w-full sm:max-w-[250px] md:max-w-[300px] lg:max-w-[350px] mt-2">
                        <span class="block">{{ $product->name }}</span>
                    </div>

                    <!-- Thumbnails -->
                    @if($product->variants->count() > 0)
                        <div class="flex space-x-2 my-2">
                            @foreach ($product->variants as $variant)
                                <div class="bg-white border rounded-none group overflow-hidden max-w-20">
                                    <img src="{{ asset($variant->image) }}" alt="{{ $product->name }}"
                                        class="mx-auto transition-all duration-500 p-[1px] border-0 group-hover:bg-black" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </a>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->appends(['keyword' => $keyword])->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
