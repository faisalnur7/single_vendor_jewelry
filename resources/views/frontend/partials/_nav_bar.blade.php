@php
    $categories = \App\Models\Category::with('subcategories.childsubcategories')->where('show_on_main_menu','1')->get();
@endphp
<nav class="hidden md:flex gap-6 items-center text-lg font-bold">
    <div class="relative group w-full">
        <a href="#"
            class="hover:text-orange-500 flex items-center gap-1 px-4 py-2 whitespace-nowrap text-xl">Categories <i
                class="fa-solid fa-angle-down"></i></a>

        <!-- Dropdown -->
        <div
            class="absolute left-1/2 top-full z-50 w-[1100px] bg-white border shadow-2xl pl-4 pt-6 rounded-lg transform -translate-x-1/2 translate-y-[15px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
            <div class="flex gap-6">
                <!-- Left Panel -->
                <div class="col-span-2 border-r">
                    <ul>
                        @foreach ($categories as $category)
                            <li class="p-0 min-w-[230px] left_panel" data-id="{{ $category->id }}">
                                <div class="flex justify-between items-center text-gray-600 hover:text-black py-2 pr-3">
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="font-normal text-lg">{{ $category->name }}</a>
                                    <svg class="w-4 h-4 text-gray-400 hover:text-black" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Right Panel -->
                <div class="flex flex-col overflow-y-scroll overflow-x-hidden w-full max-h-[600px]" id="right_panel">
                    @foreach ($categories as $category)
                        <div class="right-content @if ($loop->iteration !== 1) hidden @else first_category @endif"
                            data-id="{{ $category->id }}">
                            @foreach ($category->subcategories as $subcategory)
                                <div class="mb-6">
                                    <h3 class=" font-semibold mb-2 underline text-[22px]">
                                        <a
                                            href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                    </h3>
                                    <ul class="grid grid-cols-6 gap-4">
                                        @foreach ($subcategory->child_sub_categories as $child)
                                            <li>
                                                <a href="{{ route('childsubcategory.show', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                    class="text-sm hover:text-orange-500 flex flex-col gap-2 items-center text-center">
                                                    <img src="{{ asset($child->image) }}"
                                                        class="rounded-full w-28 scale-90 hover:scale-110 transition-all object-fill" />
                                                    <span
                                                        class="font-normal whitespace-normal">{{ $child->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <a href="{{route('best_sellers')}}" class="hover:text-orange-500  whitespace-nowrap">Best Sellers</a>
</nav>

<!-- Mobile Navbar -->
<div class="md:hidden">
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
            <h3 class="font-bold text-xl mb-4">Categories</h3>
            <ul>
                @foreach ($categories as $category)
                    <li class="mb-3">
                        <a href="{{ route('category.show', $category->slug) }}" 
                           class="block text-lg hover:text-orange-500">
                           {{ $category->name }}
                        </a>

                        @if($category->subcategories->count())
                            <ul class="ml-4 mt-2 space-y-2">
                                @foreach ($category->subcategories as $subcategory)
                                    <li>
                                        <a href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}" 
                                           class="text-gray-600 hover:text-orange-500">
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

            <a href="{{ route('best_sellers') }}" 
               class="block text-lg hover:text-orange-500">
               Best Sellers
            </a>
        </div>
    </div>
</div>


<script>
    $(function() {
        const $rightContents = $('.right-content');

        $('.left_panel').on('mouseover', function() {
            const id = $(this).data('id');
            $rightContents.addClass('hidden');
            $rightContents.filter(`[data-id="${id}"]`).removeClass('hidden');
        });

        // Trigger the first category on load
        $('.left_panel').first().trigger('mouseover');
    });
</script>

<!-- Script -->
<script>
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeMenuBtn = document.getElementById('closeMenuBtn');
    const menuOverlay = document.getElementById('menuOverlay');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('-translate-x-full');
        mobileMenu.classList.add('translate-x-0');
        menuOverlay.classList.remove('hidden');
    });

    closeMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('translate-x-0');
        mobileMenu.classList.add('-translate-x-full');
        menuOverlay.classList.add('hidden');
    });

    menuOverlay.addEventListener('click', () => {
        mobileMenu.classList.remove('translate-x-0');
        mobileMenu.classList.add('-translate-x-full');
        menuOverlay.classList.add('hidden');
    });
</script>