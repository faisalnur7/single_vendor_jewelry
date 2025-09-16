<!-- Header -->
@php
    $languages = [
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
        'pt' => ['name' => 'Portuguese', 'flag' => '🇵🇹'],
        'ar' => ['name' => 'Arabic', 'flag' => '🇸🇦'],
        'es' => ['name' => 'Spanish', 'flag' => '🇪🇸'],
        'fr' => ['name' => 'French', 'flag' => '🇫🇷'],
        'it' => ['name' => 'Italian', 'flag' => '🇮🇹'],
        'de' => ['name' => 'German', 'flag' => '🇩🇪'],
        'sv' => ['name' => 'Swedish', 'flag' => '🇸🇪'],
        'no' => ['name' => 'Norwegian', 'flag' => '🇳🇴'],
        'tr' => ['name' => 'Turkish', 'flag' => '🇹🇷'],
        'hi' => ['name' => 'Hindi', 'flag' => '🇮🇳'],
        'ru' => ['name' => 'Russian', 'flag' => '🇷🇺'],
        'el' => ['name' => 'Greek', 'flag' => '🇬🇷'],
        'ro' => ['name' => 'Romanian', 'flag' => '🇷🇴'],
        'cs' => ['name' => 'Czech', 'flag' => '🇨🇿'],
        'pl' => ['name' => 'Polish', 'flag' => '🇵🇱'],
    ];
    $currentLang = session('lang', 'en');
    $contactSettings = App\Models\ContactSetting::first();
    $profile_link = auth()->check() ? route('user_profile') : '#';
    $wishlistCount = 0;

    if (auth()->check()) {
        $wishlistCount = auth()->user()->wishlists()->count();
    }

    $cartCount =
        auth()->check() && !empty(auth()->user()->cart)
            ? auth()->user()->cart->items->count() ?? 0
            : (session('guest_cart')
                ? count(session('guest_cart'))
                : 0);

@endphp
<header class="site_header flex items-center justify-between px-4 md:px-8 py-4 border-b sticky top-0 bg-white z-50">

    {{-- Mobile Sidebar Toggle Button --}}
    @auth
        <button id="sidebarToggle" class="hidden p-2 rounded-lg z-50">
            <i id="menuIcon" class="fas fa-bars text-2xl text-gray-800"></i>
        </button>
    @endauth

    {{-- Logo --}}

    <div class="flex justify-between items-center p-4 pl-0 bg-white lg:hidden">
        <button id="mobileMenuBtn" class="relative flex flex-col justify-between w-6 h-5 group">
            <span class="block h-[2px] bg-gray-800 rounded w-6"></span>
            <span class="block h-[2px] bg-gray-800 rounded w-5 mr-2"></span>
            <span class="block h-[2px] bg-gray-800 rounded w-6 mr-1"></span>
        </button>
    </div>

    <div class="flex max-w-44">
        <a href="{{ route('homepage') }}">
            <img src="{{ asset($general_settings->site_logo ?? 'assets/img/logo.png') }}"
                alt="{{ $general_settings->site_title }}" class="h-10 object-contain" style="min-width: 150px" />
        </a>
    </div>
    {{-- Navbar previous place --}}
    @include('frontend.partials._nav_bar')



    {{-- Right Icons --}}
    <div class="flex flex-wrap items-center gap-4 pl-2 lg:pl-0 lg:gap-7 text-sm">
        <!-- WhatsApp Toggle -->
        <div class="relative hidden md:block">
            @include('frontend.partials.header_icons._whatsapp_icon')
           
        </div>

        <!-- Globe Toggle -->
        <div class="relative hidden md:block">
            @include('frontend.partials.header_icons._globe_icon')
        </div>

        <!-- Search Overlay -->
        <div class="relative">
            @include('frontend.partials.header_icons._search_icon')
        </div>

        <!-- Script -->
        <div class="relative">
            @include('frontend.partials.header_icons._user_icon')
        </div>

        <div class="relative">
            @include('frontend.partials.header_icons._wishlist_icon')
        </div>

        <div class="relative">
            @include('frontend.partials.header_icons._cart_icon')
        </div>
    </div>

</header>
<!-- Search Overlay (outside header, full width) -->
<div id="searchOverlay" class="hidden fixed top-0 left-0 w-full bg-white shadow-lg z-50 pt-6">
    <div class="max-w-7xl mx-auto h-full flex items-center justify-center gap-6 px-4 relative">
        <!-- Search Input -->
        <input type="text" id="searchKeyword" placeholder="Search products..."
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <!-- Close Button -->
        <button id="searchClose" class="text-gray-900 hover:text-gray-700 text-xl font-bold">
            &times;
        </button>
    </div>

    <!-- Search Results Container -->
    <div id="searchResults"
        class="absolute top-full left-0 w-full bg-white shadow-lg max-h-[500px] overflow-y-auto pl-4 pb-4 pr-4 flex flex-wrap gap-4">
    </div>
</div>


<script>
    document.getElementById("globalToggle").addEventListener("click", function() {
        document.getElementById("globalMenu").classList.toggle("hidden");
    });
    // Open overlay
    $('#searchToggle').on('click', function() {
        $('#searchOverlay').toggleClass('hidden');
    });

    // Close overlay
    $('#searchClose').on('click', function() {
        $('#searchOverlay').addClass('hidden');
        $('#searchKeyword').val('');
        $('#searchResults').html('');
    });

    // AJAX search on input
    $('#searchKeyword').on('keyup', function() {
        var keyword = $(this).val().trim();

        if (keyword.length < 2) {
            $('#searchResults').html('');
            return;
        }

        $.ajax({
            url: "{{ route('ajaxSearchProducts') }}",
            type: 'GET',
            data: {
                keyword: keyword
            },
            success: function(response) {
                var html = '';
                var baseUrl = "{{ asset('') }}"; // Laravel base URL
                if (response.products.length > 0) {
                    console.log(response.products)
                    response.products.forEach(function(product) {
                        html += `
                    <div class="flex flex-col product_card w-[200px] border rounded p-2">
                        <a href="/product/${product.slug}">
                            <div class="relative bg-white border rounded-none group overflow-hidden">
                                <img src="${baseUrl}${product.image}" alt="${product.name}" class="mx-auto transition-transform duration-[3000ms] group-hover:scale-[1.5]" />
                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 transform flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <button class="bg-white rounded-full shadow flex justify-center items-center w-10 h-10 transition-colors duration-300 hover:bg-black group/icon">
                                        <i class="fa-solid fa-eye text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                                    </button>
                                    <button class="wishlist_btn bg-white rounded-full shadow flex justify-center items-center w-10 h-10 transition-colors duration-300 hover:bg-black group/icon" data-product_id="${product.id}">
                                        <i class="fa-regular fa-heart text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-md overflow-hidden text-ellipsis w-full mt-2">
                                <span class="block">${product.name}</span>
                            </div>
                        </a>
                    </div>
                    `;
                    });

                    html += `<div class="w-full text-center mt-2">
                            <button id="viewMoreBtn" data-keyword="${keyword}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">View More</button>
                        </div>`;
                } else {
                    html = '<div class="text-gray-500">No products found</div>';
                }
                $('#searchResults').html(html);
            }
        });
    });

    // Redirect to full search page when clicking View More
    $(document).on('click', '#viewMoreBtn', function() {
        var keyword = $(this).data('keyword');
        window.location.href = "{{ route('searchPage') }}?keyword=" + encodeURIComponent(keyword);
    });
    $(document).ready(function() {
        const $toggleBtn = $('#currencyToggle');
        const $menu = $('#currencyMenu');

        // Toggle dropdown
        $toggleBtn.on('click', function(e) {
            e.stopPropagation();
            $menu.toggleClass('hidden');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$toggleBtn.is(e.target) && !$menu.is(e.target) && $menu.has(e.target).length === 0) {
                $menu.addClass('hidden');
            }
        });
    });

    // Toggle WhatsApp menu
    $('#whatsappToggle').on('click', function(e) {
        e.stopPropagation();
        $('#whatsappMenu').toggleClass('hidden');
    });

    // Close when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#whatsappToggle, #whatsappMenu').length) {
            $('#whatsappMenu').addClass('hidden');
        }
    });
</script>
