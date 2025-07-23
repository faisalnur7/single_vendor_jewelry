<!DOCTYPE html>
<html lang="en">
@php
    $general_settings = App\Models\GeneralSetting::first();
@endphp
<head>
    @include('frontend.partials._head')
    @yield('styles')
</head>

<body class="font-sans bg-white text-gray-800">
    @include('frontend.partials._top_bar')
    @include('frontend.partials._header')

    @yield('contents')
    @include('frontend.partials._login')
    @include('frontend.partials._footer')
    @include('frontend.partials._script')
    @yield('scripts')
</body>

</html>
