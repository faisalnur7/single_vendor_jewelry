@php
    $categories = \App\Models\Category::with('subcategories.childsubcategories')
        ->where('show_on_main_menu', '1')
        ->orderBy('order', 'asc')
        ->get();
@endphp
<nav class="hidden lg:flex flex-wrap gap-3 px-6 lg:gap-6 items-center text-sm lg:text-sm font-bold">
    @foreach ($categories as $category)
        <div class="relative group">
            <!-- Top-level category link -->
            <a href="{{ route('category.show', $category->slug) }}"
                class="hover:text-orange-500 flex items-center gap-0 md:gap-1 px-0 py-3 whitespace-nowrap text-lg font-bold">
                <span data-translate>{{ $category->name }}</span>
                @if ($category->subcategories->count() > 0)
                    <i class="fa-solid fa-angle-down"></i>
                @endif
            </a>

            <!-- Dropdown: only if subcategories exist -->
            @if ($category->subcategoriesSorted->count() > 0)
                <div
                    class="absolute left-0 top-full z-50 w-52 bg-white border shadow-lg rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 mt-2">
                    <ul class="flex flex-col">
                        @foreach ($category->subcategoriesSorted as $subcategory)
                            <li class="relative group">
                                <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}"
                                    data-subcategory_id="{{ $subcategory->id }}"
                                    class="subcategory_{{ $subcategory->id }} block px-2 py-2 text-gray-700 text-lg hover:text-orange-500 hover:bg-gray-100 flex justify-between items-center">
                                    <span data-translate>{{ $subcategory->name }}</span>
                                    @if ($subcategory->child_sub_categories->count() > 0)
                                        <i class="fa-solid fa-angle-right"></i>
                                    @endif
                                </a>

                                <!-- Child Subcategories -->
                                @if ($subcategory->child_sub_categories->count() > 0)
                                    <div
                                        class="absolute child_{{ $subcategory->id }} top-1 left-full z-50 w-48 bg-white border shadow-lg rounded-lg opacity-0 hidden transition-all duration-200">
                                        <ul class="flex flex-col">
                                            @foreach ($subcategory->child_sub_categories as $child)
                                                <li>
                                                    <a href="{{ route('childsubcategory.show', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                        class="block px-2 py-2 text-gray-700 text-lg hover:text-orange-500 hover:bg-gray-100"
                                                        data-translate>
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endforeach


                    </ul>
                </div>
            @endif

        </div>
    @endforeach
</nav>


<!-- Mobile Navbar -->
<div class="lg:hidden">
    <!-- Slide Menu -->
    <div id="mobileMenu"
        class="fixed inset-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Overlay with blur effect -->
        <div id="menuOverlay"
            class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/40 backdrop-blur-sm hidden transition-opacity duration-300 ease-in-out">
        </div>

        <!-- Drawer -->
        <div class="relative bg-white w-80 h-full shadow-2xl overflow-hidden">

            <!-- Gradient Header Background -->
            <div
                class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-br from-orange-500 via-orange-600 to-red-500 opacity-10">
            </div>

            <div class="relative p-6 overflow-y-auto h-full">
                <!-- Logo + Close button -->
                <div class="flex items-center justify-between mb-8">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-orange-500 rounded-lg blur opacity-20 group-hover:opacity-30 transition">
                            </div>
                            <img src="{{ asset($general_settings->site_logo ?? 'assets/img/logo.png') }}"
                                alt="Logo"
                                class="relative h-10 w-auto transform group-hover:scale-105 transition duration-200">
                        </div>
                    </a>

                    <!-- Close button -->
                    <button id="closeMenuBtn"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-500 transition-all duration-200 transform hover:rotate-90">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Menu Header -->
                <div class="mb-6">
                    <h3
                        class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-red-600 flex items-center gap-2">
                        <i class="fa-solid fa-grid-2 text-orange-500"></i>
                        Categories
                    </h3>
                    <div class="h-1 w-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full mt-2"></div>
                </div>

                <!-- Menu items -->
                <ul class="space-y-2 mb-6">
                    @foreach ($categories as $category)
                        <li>
                            <button
                                class="flex justify-between items-center w-full text-left px-4 py-3 rounded-xl text-base font-semibold text-gray-800 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-600 transition-all duration-200 group"
                                onclick="toggleMenu(this)">
                                <span class="flex items-center gap-3">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    {{ $category->name }}
                                </span>
                                @if ($category->subcategories->count())
                                    <i
                                        class="fa-solid fa-chevron-down text-sm transition-transform duration-200 group-hover:text-orange-500"></i>
                                @endif
                            </button>

                            @if ($category->subcategories->count())
                                <ul class="ml-6 mt-1 space-y-1 hidden overflow-hidden transition-all duration-300">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <button
                                                class="flex justify-between items-center w-full text-left px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 group"
                                                onclick="toggleMenu(this)">
                                                <span class="flex items-center gap-2">
                                                    <i
                                                        class="fa-solid fa-circle text-[4px] text-gray-400 group-hover:text-orange-500"></i>
                                                    {{ $subcategory->name }}
                                                </span>
                                                @if ($subcategory->child_sub_categories->count())
                                                    <i
                                                        class="fa-solid fa-chevron-right text-xs opacity-50 group-hover:opacity-100"></i>
                                                @endif
                                            </button>

                                            @if ($subcategory->child_sub_categories->count())
                                                <ul class="ml-6 mt-1 space-y-1 hidden">
                                                    @foreach ($subcategory->child_sub_categories as $child)
                                                        <li>
                                                            <a href="{{ route('childsubcategory.show', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                                class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-gray-500 hover:bg-gradient-to-r hover:from-orange-50 hover:to-transparent hover:text-orange-600 transition-all duration-200 group">
                                                                <i
                                                                    class="fa-solid fa-angle-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                                                {{ $child->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <!-- Divider with gradient -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-xs text-gray-400 uppercase tracking-wider">Get in touch</span>
                    </div>
                </div>

                <!-- Extra Section -->
                <div class="text-center pb-6">
                    <a href="#"
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-full shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40 hover:scale-105 transition-all duration-200 font-semibold">
                        <i class="fa-solid fa-envelope"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $("[class^='subcategory_']").each(function() {
            let subcategory_id = $(this).data('subcategory_id');
            let $childMenu = $('.child_' + subcategory_id);

            // Show child menu on hover
            $(this).parent('li').hover(
                function() {
                    $childMenu.removeClass('hidden opacity-0');
                },
                function() {
                    $childMenu.addClass('hidden opacity-0');
                }
            );
        });

        // ===== Desktop: hover dropdowns (optional if extra right-content exists) =====
        const $rightContents = $('.right-content');
        if ($rightContents.length) {
            $('.left_panel').on('mouseover', function() {
                const id = $(this).data('id');
                $rightContents.addClass('hidden');
                $rightContents.filter(`[data-id="${id}"]`).removeClass('hidden');
            });

            // Trigger the first category on page load
            $('.left_panel').first().trigger('mouseover');
        }

        // ===== Mobile Menu Toggle =====
        const $mobileMenuBtn = $('#mobileMenuBtn');
        const $mobileMenu = $('#mobileMenu');
        const $closeMenuBtn = $('#closeMenuBtn');
        const $menuOverlay = $('#menuOverlay');

        function openMobileMenu() {
            $mobileMenu.removeClass('-translate-x-full').addClass('translate-x-0');
            $menuOverlay.removeClass('hidden');
        }

        function closeMobileMenu() {
            $mobileMenu.addClass('-translate-x-full').removeClass('translate-x-0');
            $menuOverlay.addClass('hidden');
        }

        $mobileMenuBtn.on('click', openMobileMenu);
        $closeMenuBtn.on('click', closeMobileMenu);
        $menuOverlay.on('click', closeMobileMenu);

        // ===== Optional: mobile submenu toggle =====
        // If you want categories in mobile to expand/collapse subcategories
        $('#mobileMenu ul li > a').on('click', function(e) {
            const $subMenu = $(this).siblings('ul');
            if ($subMenu.length) {
                e.preventDefault(); // prevent default link
                $subMenu.slideToggle(200); // smooth slide animation
            }
        });
    });

    function toggleMenu(button) {
        const submenu = button.nextElementSibling;
        if (submenu) {
            const icon = button.querySelector('i.fa-chevron-down, i.fa-chevron-right');
            submenu.classList.toggle('hidden');
            if (icon && icon.classList.contains('fa-chevron-down')) {
                icon.style.transform = submenu.classList.contains('hidden') ? 'rotate(0deg)' :
                    'rotate(180deg)';
            }
        }
    }
</script>
