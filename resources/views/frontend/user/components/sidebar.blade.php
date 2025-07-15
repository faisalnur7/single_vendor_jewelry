<aside id="sidebar"
    class="z-30 w-full md:w-64 rounded-xl bg-white/80 backdrop-blur-lg shadow-xl border border-gray-200 transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out">
    <div class="p-6 text-center border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 tracking-wide">👤 My Account</h2>
    </div>

    <nav class="p-4 space-y-2 text-sm font-medium">
        <a href="{{ route('user_dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ request()->routeIs('user_dashboard') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-tachometer-alt w-5"></i> Dashboard
        </a>

        <a href="{{ route('user_order') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ request()->routeIs('user_order.*') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-box w-5"></i> My Orders
        </a>
            
        <a href="{{ route('user_address') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
            {{ request()->routeIs('user_address.*') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
            <i class="fas fa-map-marker-alt w-5"></i> Shipping Addresses
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition">
            <i class="fas fa-edit w-5"></i> Edit Profile
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition">
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
