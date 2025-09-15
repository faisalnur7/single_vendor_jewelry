<!-- Header -->
<header class="flex items-center justify-between px-6 py-4 border-b sticky top-0 bg-white z-40 site_header">

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

    {{-- Navigation --}}
    @include('frontend.partials._nav_bar')

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
    @endphp

    {{-- Right Icons --}}
    <div class="flex items-center gap-2 pl-2 lg:pl-0 lg:gap-4 text-sm">

        <!-- WhatsApp Toggle -->
        <div class="relative hidden md:block">
            <!-- WhatsApp Button -->
            <button id="whatsappToggle" class="flex items-center gap-2 rounded-lg px-1 py-1 hover:bg-gray-100">
                <img src="{{ asset('/assets/img/whatsapp.png') }}" class="w-8" />
            </button>

            <!-- WhatsApp Card -->
            <div id="whatsappMenu"
                class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-3 space-y-3 text-center">

                <p class="text-lg mb-4 font-bold text-gray-900">Stainless Steel Jewelry</p>
                <a href="{{$contactSettings?->whatsapp_link}}" target="_blank">{{$contactSettings?->whatsapp_link}}</a>
                <span class="block text-sm font-semibold text-gray-600">WhatsApp Business Account</span>

                <!-- QR Code -->
                <div class="flex justify-center">
                    <img src="{{ asset($contactSettings?->whatsapp_qr) }}" alt="WhatsApp QR"
                        class="w-42 h-42 rounded-md border" />
                </div>
            </div>
        </div>

        <!-- Globe Toggle -->
        <div class="relative hidden md:block">
            <!-- Globe Button -->
            <button id="globalToggle" class="flex items-center gap-2  rounded-lg px-3 py-1 hover:bg-gray-100">
                <img src="{{ asset('/assets/img/globe.png') }}" class="w-6" />
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>

            <!-- Wrapper for Currency + Language -->
            <div id="globalMenu"
                class="hidden absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-3 space-y-3">

                <!-- Currency Dropdown -->
                <div>
                    <span class="block text-sm font-semibold px-2 py-1 text-gray-600">Currency</span>
                    <form action="{{ route('setCurrency') }}" method="POST" id="currencyForm" class="flex flex-col">
                        @csrf
                        <select name="currency" onchange="this.form.submit()"
                            class="block w-full border rounded px-3 py-2 text-gray-700 focus:ring focus:ring-blue-200">
                            <option value="USD" {{ session('currency', 'USD') == 'USD' ? 'selected' : '' }}>$ USD
                            </option>
                            <option value="RMB" {{ session('currency') == 'RMB' ? 'selected' : '' }}>¥ RMB</option>
                        </select>
                    </form>
                </div>

                <!-- Language Dropdown -->
                <div>
                    <span class="block text-sm font-semibold px-2 py-1 text-gray-600">Language</span>
                    <div class="flex flex-col">
                        <select id="languageSelect" class="border rounded px-3 py-2">
                            @foreach ($languages as $code => $lang)
                                <option value="{{ $code }}" {{ $currentLang === $code ? 'selected' : '' }}>
                                    {{ $lang['flag'] }} {{ $lang['name'] }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
        </div>

        <!-- Script -->
        <script>
            document.getElementById("globalToggle").addEventListener("click", function() {
                document.getElementById("globalMenu").classList.toggle("hidden");
            });
        </script>



        <!-- Search Overlay -->
        <div class="relative">
            <!-- Search Icon -->
            <button id="searchToggle" class="text-lg">
                {{-- <i class="fa-solid fa-magnifying-glass"></i> --}}
                <img src="{{ asset('/assets/img/search.png') }}" class="w-7" />
            </button>
        </div>



        @php
            $profile_link = auth()->check() ? route('user_profile') : '#';
        @endphp

        <a href="{{ $profile_link }}" class="text-lg header-user-icon hidden md:block">
            {{-- <i class="fa-regular fa-user"></i> --}}
            <img src="{{ asset('/assets/img/user.png') }}" class="w-7" />
        </a>
        @php
            $wishlistCount = 0;
            if (auth()->check()) {
                $wishlistCount = auth()->user()->wishlists()->count();
            }
        @endphp

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

        <a href="{{ route('cart') }}" class="relative text-xl">
            {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
            <img src="{{ asset('/assets/img/trolley.png') }}" class="w-7" />
            @php
                $cartCount =
                    auth()->check() && !empty(auth()->user()->cart)
                        ? auth()->user()->cart->items->count() ?? 0
                        : (session('guest_cart')
                            ? count(session('guest_cart'))
                            : 0);
            @endphp

            <span
                class="absolute -top-1 -right-2 @if ($cartCount == 0) bg-transparent @else bg-red-500 @endif  text-white text-xs font-bold rounded-full px-1.5 py-0.5 leading-none cart_count">
                @if ($cartCount > 0)
                    {{ $cartCount }}
                @endif
            </span>
        </a>
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
        class="absolute top-full left-0 w-full bg-white shadow-lg max-h-[500px] overflow-y-auto p-4 flex flex-wrap gap-4">
    </div>
</div>


<script>
    // Open overlay
    $('#searchToggle').on('click', function() {
        $('#searchOverlay').toggleClass('hidden');
        $('#searchKeyword').focus();
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
    $('#whatsappToggle').on('click', function (e) {
        e.stopPropagation();
        $('#whatsappMenu').toggleClass('hidden');
    });

    // Close when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#whatsappToggle, #whatsappMenu').length) {
            $('#whatsappMenu').addClass('hidden');
        }
    });

</script>
