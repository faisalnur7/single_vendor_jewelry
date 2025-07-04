<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.partials._head')
    @yield('styles')
</head>

<body class="font-sans bg-white text-gray-800">
    @include('frontend.partials.checkout._checkout_header')

    @yield('contents')
    @yield('scripts')
</body>

</html>
