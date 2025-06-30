<!-- Header -->
<header class="flex items-center justify-between px-6 py-4 border-b sticky top-0 bg-white z-40">
    <div class="flex max-w-44">
        <img src="{{ asset('assets/img/logo.png') }}" />
    </div>
    @include('frontend.partials._nav_bar')
    <div class="flex items-center gap-4 text-sm">
        <a href="#" class="hover:underline">EN / USD</a>
        <a href="#" class="text-lg">
            <i class="fa-regular fa-user"></i>
        </a>
        <a href="#" class="text-lg">
            <i class="fa-regular fa-heart"></i>
        </a>
        <a href="{{route('cart')}}" class="relative text-lg">
            <i class="fa-solid fa-cart-shopping"></i>
            @php
                $cartCount = session()->has('guest_cart') ? count(session('guest_cart')) : 0;
            @endphp
            @if($cartCount > 0)
                <span class="cart-count absolute -top-1 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5 flex justify-center items-center leading-none">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

    </div>
</header>