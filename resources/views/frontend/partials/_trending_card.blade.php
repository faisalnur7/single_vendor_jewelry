@php
    $wholesale_trendings = \App\Models\Category::where('show_on_main_menu', '0')->where('is_trending', '1')->orderBy('order', 'asc')->get();
@endphp

@foreach ($wholesale_trendings as $trending)
    <a href="{{route('category.show', $trending->slug)}}">
        <div class="relative bg-white border rounded-lg group overflow-hidden">
            <img src="{{ asset($trending->image) }}" alt="{{ $trending->name }}"
                class="mx-auto transition-transform duration-1000 group-hover:scale-[1.5] group-hover:rotate-12" />
            <div
                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                <span class="text-white text-lg font-semibold text-center px-2">{{ $trending->name }}</span>
            </div>
        </div>
    </a>
@endforeach
