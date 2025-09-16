<a href="{{ route('cart') }}" class="relative text-xl">
    {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
    <img src="{{ asset('/assets/img/trolley.png') }}" class="w-7" />
    <span
        class="absolute -top-1 -right-2 @if ($cartCount == 0) bg-transparent @else bg-red-500 @endif  text-white text-xs font-bold rounded-full px-1.5 py-0.5 leading-none cart_count">
        @if ($cartCount > 0)
            {{ $cartCount }}
        @endif
    </span>
</a>
