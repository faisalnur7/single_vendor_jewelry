<!DOCTYPE html>
{{-- <html lang="en" class="overflow-x-hidden lg:overflow-x-visible"> --}}
<html lang="en">
@php
    $general_settings = App\Models\GeneralSetting::first();
@endphp
<head>
    @include('frontend.partials._head')
    @yield('styles')
</head>

<body class="font-sans bg-white text-gray-800 overflow-x-hidden body_class">
    {{-- @include('frontend.partials._top_bar') --}}
    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="fixed inset-0 bg-white bg-opacity-70 z-50 flex items-center justify-center">
            <img src="{{asset('/infinity_transparent.gif')}}" />
    </div>

    @include('frontend.partials._header')

    @yield('contents')
    @include('frontend.partials._login')
    @include('frontend.partials._footer')
    @include('frontend.partials._script')
    @yield('scripts')
</body>

</html>
