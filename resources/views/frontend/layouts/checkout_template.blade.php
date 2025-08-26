<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $general_settings = App\Models\GeneralSetting::first();
    @endphp
    @include('frontend.partials._head')
    @include('frontend.partials.checkout._checkout_styles')
    @yield('styles')
    @yield('head_scripts')
</head>

<body class="font-sans bg-white text-gray-800">
    @include('frontend.partials.checkout._checkout_header')

    @yield('contents')
    @yield('scripts')
</body>

</html>
