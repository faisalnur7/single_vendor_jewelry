@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry - User Profile')

@section('contents')
    <div class="w-full bg-gradient-to-br from-orange-50 via-white to-white min-h-screen text-gray-800">
        {{-- Sidebar Overlay --}}
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden"></div>

        <div class="mx-auto w-full max-w-[1440px] flex flex-col md:flex-row px-4 md:px-0 py-6 gap-6">
            {{-- Sidebar --}}
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

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition">
                        <i class="fas fa-credit-card w-5"></i> Payment Methods
                    </a>

                    <a href="{{ route('user_address') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition
        {{ request()->routeIs('user_address.*') ? 'bg-orange-500 text-white' : 'hover:bg-orange-100 text-gray-700' }}">
                        <i class="fas fa-map-marker-alt w-5"></i> Shipping Addresses
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition">
                        <i class="fas fa-edit w-5"></i> Edit Profile
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 transition">
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

            {{-- Main Content --}}
            {{-- Main Content --}}
            <main class="flex-1 p-6 bg-white rounded-xl shadow-xl border border-gray-100">
                {{-- Breadcrumb --}}
                <div class="text-sm text-gray-500 mb-4">
                    <a href="{{ route('homepage') }}" class="hover:underline text-gray-600">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-500">Dashboard</span>
                </div>

                {{-- Profile Info --}}
                <div class="flex items-center gap-4 mb-8">
                    <img src="https://i.pravatar.cc/80?u={{ Auth::id() }}" alt="User Avatar"
                        class="w-16 h-16 rounded-full border border-gray-300 shadow">
                    <div>
                        <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                {{-- Quick Stats / Links --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="#"
                        class="bg-gradient-to-br from-white via-orange-50 to-white p-6 rounded-xl border border-gray-100 shadow hover:shadow-lg transition group">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="p-3 bg-orange-100 text-orange-600 rounded-full group-hover:bg-orange-500 group-hover:text-white transition">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Profile Info</h3>
                        </div>
                        <p class="text-sm text-gray-500">Update your name, email and password.</p>
                    </a>

                    <a href="#"
                        class="bg-gradient-to-br from-white via-orange-50 to-white p-6 rounded-xl border border-gray-100 shadow hover:shadow-lg transition group">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="p-3 bg-orange-100 text-orange-600 rounded-full group-hover:bg-orange-500 group-hover:text-white transition">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                        </div>
                        <p class="text-sm text-gray-500">View or track your recent purchases.</p>
                    </a>

                    <a href="#"
                        class="bg-gradient-to-br from-white via-orange-50 to-white p-6 rounded-xl border border-gray-100 shadow hover:shadow-lg transition group">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="p-3 bg-orange-100 text-orange-600 rounded-full group-hover:bg-orange-500 group-hover:text-white transition">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Saved Addresses</h3>
                        </div>
                        <p class="text-sm text-gray-500">Manage your shipping addresses.</p>
                    </a>
                </div>
            </main>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('-translate-x-full');
                $('#overlay').toggleClass('hidden');
                $('#menuIcon').toggleClass('hidden');
            });

            $('#overlay, .user_menu_close').on('click', function() {
                $('#sidebar').addClass('-translate-x-full');
                $('#overlay').addClass('hidden');
                $('#menuIcon').removeClass('hidden');
            });
        });
    </script>
@endsection
