@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry - User Profile')

@section('contents')
    <div class="w-full bg-gradient-to-br from-orange-50 via-white to-white min-h-screen text-gray-800">
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden"></div>

        <div class="mx-auto max-w-[1440px] h-auto min-h-screen flex flex-col md:flex-row px-4 md:px-0 py-6 gap-6">
            {{-- Sidebar --}}
            @include('frontend.user.components.sidebar')

            {{-- Main Content --}}
            <main class="flex-1 p-6 bg-white rounded-xl shadow-xl border border-gray-100">
                @yield('user_contents')
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('-translate-x-full');
                $('#overlay').toggleClass('hidden');
                $('#menuIcon').toggleClass('hidden');
            });

            $('#overlay, .user_menu_close').on('click', function () {
                $('#sidebar').addClass('-translate-x-full');
                $('#overlay').addClass('hidden');
                $('#menuIcon').removeClass('hidden');
            });
        });
    </script>
@endsection
