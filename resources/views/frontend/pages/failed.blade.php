@extends('frontend.layouts.checkout_template')
@section('title', 'Payment Failed')

@section('contents')
<div class="max-w-3xl mx-auto py-20 text-center">
    <h1 class="text-3xl font-bold text-red-600 mb-4">❌ Payment Failed</h1>
    <p class="text-lg">{{ session('error') ?? 'Something went wrong. Please try again.' }}</p>
    <a href="{{ route('checkout') }}" class="inline-block mt-6 px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
        Return to Checkout
    </a>
</div>
@endsection
