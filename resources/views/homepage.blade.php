<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.partials._head')
    @yield('styles')
</head>

<body class="font-sans bg-white text-gray-800">
    @include('frontend.partials._top_bar')

    <!-- Header -->
    <header class="flex items-center justify-between px-6 py-4 border-b">
        <div class="flex max-w-44">
            <img src="{{asset('assets/img/logo.png')}}" />
        </div>
        
        @include('frontend.partials._nav_bar')

        

        <div class="flex items-center gap-4 text-sm">
            <a href="#" class="text-green-600 text-xl">&#x1F4F2;</a>
            <a href="#" class="hover:underline">EN / USD</a>
            <a href="#" class="text-lg">&#128100;</a>
            <a href="#" class="text-lg">&#10084;</a>
            <a href="#" class="text-lg">&#128722;</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-beige text-center py-12 px-4 bg-gradient-to-br from-amber-100 to-white">
        <h1 class="text-5xl font-bold text-brown-900 mb-4">FREE SHIPPING</h1>
        <div class="flex justify-center gap-6 flex-wrap text-brown-800 text-lg font-medium">
            <div class="bg-white px-6 py-3 rounded-full border shadow">✔ Free 7 days Return</div>
            <div class="bg-white px-6 py-3 rounded-full border shadow">✔ Free Shipping Over $150</div>
            <div class="bg-white px-6 py-3 rounded-full border shadow">✔ No Order Minimum</div>
        </div>
        <div class="mt-8">
            <img src="https://via.placeholder.com/250x350?text=Woman+with+Bags" alt="Model"
                class="mx-auto rounded-lg shadow-lg" />
        </div>
    </section>

    <!-- Product Section -->
    <section class="py-12 px-6">
        <h2 class="text-3xl font-bold text-center mb-8">Wholesale Trending Discovery</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <div class="bg-white p-4 border rounded-lg shadow hover:shadow-lg">
                <img src="https://via.placeholder.com/150" alt="Product 1" class="mx-auto" />
            </div>
            <div class="bg-white p-4 border rounded-lg shadow hover:shadow-lg">
                <img src="https://via.placeholder.com/150" alt="Product 2" class="mx-auto" />
            </div>
            <div class="bg-white p-4 border rounded-lg shadow hover:shadow-lg">
                <img src="https://via.placeholder.com/150" alt="Product 3" class="mx-auto" />
            </div>
            <div class="bg-white p-4 border rounded-lg shadow hover:shadow-lg">
                <img src="https://via.placeholder.com/150" alt="Product 4" class="mx-auto" />
            </div>
            <div class="bg-white p-4 border rounded-lg shadow hover:shadow-lg">
                <img src="https://via.placeholder.com/150" alt="Product 5" class="mx-auto" />
            </div>
            <div class="bg-white p-4 border rounded-lg shadow hover:shadow-lg">
                <img src="https://via.placeholder.com/150" alt="Product 6" class="mx-auto" />
            </div>
        </div>
    </section>

@yield('scripts')
</body>

</html>
