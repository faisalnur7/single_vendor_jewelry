@php
    $categories = \App\Models\Category::with('subcategories.childsubcategories')->where('show_on_main_menu','1')->get();
@endphp
<nav class="hidden xl:flex gap-3 xl:gap-6 items-center text-sm xl:text-lg font-bold">
    @foreach ($categories as $category)
        <div class="relative group">
            <!-- Top-level category link -->
            <a href="{{ route('category.show', $category->slug) }}"
               class="hover:text-orange-500 flex items-center gap-0 md:gap-1 px-0 py-3 whitespace-nowrap text-md font-bold">
                <span data-translate>{{ $category->name }}</span>
                @if($category->subcategories->count() > 0)
                    <i class="fa-solid fa-angle-down"></i>
                @endif
            </a>

            <!-- Dropdown: only if subcategories exist -->
            @if($category->subcategories->count() > 0)
                <div class="absolute left-0 top-full z-50 w-48 bg-white border shadow-lg rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 mt-2">
                    <ul class="flex flex-col">
                        @foreach ($category->subcategories as $subcategory)
                            <li>
                                <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}"
                                   class="block px-2 py-2 text-gray-700 hover:text-orange-500 hover:bg-gray-100">
                                    {{ $subcategory->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endforeach
</nav>


<!-- Mobile Navbar -->
<div class="xl:hidden">
    <!-- Slide Menu -->
    <div id="mobileMenu" 
         class="fixed inset-0 z-50 transform -translate-x-full transition-transform duration-300">
        <!-- Overlay -->
        <div id="menuOverlay" class="absolute inset-0 bg-black bg-opacity-50 hidden"></div>

        <!-- Drawer -->
        <div class="relative bg-white w-80 h-full shadow-lg p-6 overflow-y-auto">
            <!-- Close button -->
            <button id="closeMenuBtn" class="absolute top-4 right-4 text-2xl">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Menu items -->
            <h3 class="font-bold text-xl mb-4" >Categories</h3>
            <ul>
                @foreach ($categories as $category)
                    <li class="mb-3">
                        <a href="{{ route('category.show', $category->slug) }}" 
                           class="block text-lg hover:text-orange-500" >
                           {{ $category->name }}
                        </a>

                        @if($category->subcategories->count())
                            <ul class="ml-4 mt-2 space-y-2">
                                @foreach ($category->subcategories as $subcategory)
                                    <li>
                                        <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}" 
                                           class="text-gray-600 hover:text-orange-500" >
                                           {{ $subcategory->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>

            <hr class="my-4">
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
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
</script>
