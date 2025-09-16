@php
    $featuredCategories = \App\Models\Category::where('show_on_main_menu', '0')
        ->where('is_featured', '1')
        ->orderBy('order', 'asc')
        ->get();
@endphp

@foreach ($featuredCategories as $featuredCategory)
    <a href="{{ route('category.show', $featuredCategory->slug) }}">
        <div class="flex flex-col items-center text-center mt-6">
            <div class="bg-white border rounded-full group overflow-hidden aspect-square">
                <img src="{{$featuredCategory->image}}"
                    class="mx-auto w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
            </div>
            <p class="mt-2 text-md font-bold text-gray-700">{{ $featuredCategory->name }}</p>
        </div>
    </a>
@endforeach
