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
        <a href="{{ route('cart') }}" class="relative text-lg">
            <i class="fa-solid fa-cart-shopping"></i>
            @php
                $cartCount = 0;
                if(!empty(auth()->user()) && !empty(auth()->user()->cart)){
                    $cartCount = count(auth()->user()->cart->items);
                }else{
                    $cartCount = session()->has('guest_cart') ? count(session('guest_cart')) : 0;
                }
            @endphp
            <span class="cart-count absolute -top-1 -right-2 @if($cartCount > 0) bg-red-500 @endif text-white text-xs font-bold rounded-full px-1.5 py-0.5 flex justify-center items-center leading-none">
                @if ($cartCount > 0)
                    {{ $cartCount }}
                @endif
            </span>
        </a>

    </div>
</header>
