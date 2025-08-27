<!-- Header -->
<header class="flex items-center justify-between px-6 py-4 border-b sticky top-0 bg-white z-40 site_header">

    {{-- Mobile Sidebar Toggle Button --}}
    @auth
        <button id="sidebarToggle" class="hidden p-2 rounded-lg z-50">
            <i id="menuIcon" class="fas fa-bars text-2xl text-gray-800"></i>
        </button>
    @endauth

    {{-- Logo --}}

    <div class="flex justify-between items-center p-4 bg-white md:hidden">
        <button id="mobileMenuBtn" class="relative flex flex-col justify-between w-7 h-6 group">
            <span class="block h-1 bg-gray-800 rounded w-7"></span>
            <span class="block h-1 bg-gray-800 rounded w-5 mr-2"></span>
            <span class="block h-1 bg-gray-800 rounded w-6 mr-1"></span>
        </button>
    </div>

    <div class="flex max-w-44">
        <a href="{{ route('homepage') }}">
            <img src="{{ asset($general_settings->site_logo ?? 'assets/img/logo.png') }}" alt="{{$general_settings->site_title}}" class="h-10 object-contain" />
        </a>
    </div>

    {{-- Navigation --}}
    @include('frontend.partials._nav_bar')

    {{-- Right Icons --}}
    <div class="flex items-center gap-4 text-sm">
        @php
            $profile_link = auth()->check() ? route('user_profile') : '#';
        @endphp

        <a href="{{ $profile_link }}" class="text-lg header-user-icon">
            <i class="fa-regular fa-user"></i>
        </a>

        <a href="{{ route('user_wishlist') }}" class="text-lg">
            <i class="fa-regular fa-heart"></i>
        </a>

        <a href="{{ route('cart') }}" class="relative text-lg">
            <i class="fa-solid fa-cart-shopping"></i>

            @php
                $cartCount = (auth()->check() && !empty(auth()->user()->cart))
                    ? (auth()->user()->cart->items->count() ?? 0)
                    : (session('guest_cart') ? count(session('guest_cart')) : 0);
            @endphp

                <span class="absolute -top-1 -right-2 bg-red-500 bg-transparent text-white text-xs font-bold rounded-full px-1.5 py-0.5 leading-none cart_count">
                    @if ($cartCount > 0)
                        {{ $cartCount }}
                    @endif
                </span>
        </a>
    </div>

</header>
