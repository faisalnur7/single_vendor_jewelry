<aside id="sidebar"
    class="z-30 w-full md:w-64 rounded-xl bg-white/80 backdrop-blur-lg shadow-xl border border-gray-200 transform md:translate-x-0 md:static transition-transform duration-300 ease-in-out">

    <!-- Accordion Header -->
    <div id="account-toggle"
        class="p-6 text-center border-b border-gray-200 cursor-pointer flex justify-between items-center md:cursor-default md:pointer-events-none">
        <h2 class="text-xl font-semibold text-gray-800 tracking-wide">👤 My Account</h2>
        <i id="account-chevron" class="fas fa-chevron-down text-gray-600 md:hidden"></i>
    </div>

    <!-- Collapsible Menu (hidden on mobile, always open on desktop) -->
    <nav id="account-menu" class="p-4 space-y-2 text-sm font-medium hidden md:block">
        <a href="{{ route('user_dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ request()->routeIs('user_dashboard') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-tachometer-alt w-5"></i> Dashboard
        </a>

        <a href="{{ route('user_order') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ (request()->routeIs('user_order') || request()->routeIs('user_order_show')) ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-box w-5"></i> My Orders
        </a>
            
        <a href="{{ route('user_shipping_index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ request()->routeIs('user_shipping_index') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-map-marker-alt w-5"></i> Shipping Addresses
        </a>

        <a href="{{route('user_edit_profile')}}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition
            {{ request()->routeIs('user_edit_profile') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-edit w-5"></i> Edit Profile
        </a>

        <a href="{{route('user_password_form')}}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition
            {{ request()->routeIs('user_password_form') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-lock w-5"></i> Change Password
        </a>

        <a href="{{ route('user_wishlist') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ request()->routeIs('user_wishlist') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-heart w-5"></i> Wishlist
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-red-100 text-red-600 font-medium transition">
                <i class="fas fa-sign-out-alt w-5"></i> Logout
            </button>
        </form>
    </nav>
</aside>

<script>
$(document).ready(function() {
    $("#account-toggle").on("click", function() {
        if ($(window).width() < 768) { // Only on mobile
            $("#account-menu").slideToggle(300);
            $("#account-chevron").toggleClass("fa-chevron-up fa-chevron-down");
        }
    });
});
</script>
