@php
    $productImages = [
        'Alayna.webp',
        'Chunky_Earrings.webp',
        'Enamel_Jewelry.webp',
        'Hair_Bows.webp',
        'Leopard_Print_Bags.webp',
        'Rosette_Jewelry.webp',
    ];
@endphp

@foreach ($productImages as $image)
    @php
        $imageName = str_replace('_', ' ', pathinfo($image, PATHINFO_FILENAME));
    @endphp
    <div class="relative bg-white border rounded-lg group overflow-hidden">
        <img src="{{ asset('assets/img/images/' . $image) }}" alt="{{ $imageName }}"
            class="mx-auto transition-transform duration-1000 group-hover:scale-[1.5] group-hover:rotate-12" />

        <!-- Overlay Text -->
        <div
            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
            <span class="text-white text-lg font-semibold text-center px-2">{{ $imageName }}</span>
        </div>
    </div>
@endforeach
