<a href="{{ auth()->check() ? route('user_wishlist') : route('guest_wishlist') }}"
    class="text-lg relative hidden md:block">
    {{-- <i class="fa-regular fa-heart"></i> --}}
    <img src="{{ asset('/assets/img/heart.png') }}" class="w-7" />
    <span
        class="absolute -top-1 -right-2 @if ($wishlistCount == 0) bg-transparent @else bg-red-500 @endif text-white text-xs font-bold rounded-full px-1.5 py-0.5 leading-none wishlist_count">
        @if (auth()->check() && $wishlistCount > 0)
            {{ $wishlistCount }}
        @endif
    </span>
</a>
