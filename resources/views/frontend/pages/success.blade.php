@extends('frontend.layouts.checkout_template')
@section('title', 'Payment Success')

@section('contents')
<div class="max-w-3xl space-y-3 min-h-screen items-center justify-center mx-auto py-20 text-center">
    <h1 class="text-3xl font-bold text-green-600 mb-4">🎉 Payment Successful!</h1>
    <p class="text-lg">{{ session('success') ?? 'Your order has been placed successfully.' }}</p>
    <p class="text-xl text-red-600 font-bold">Please contact this WhatsApp number for the shipping details.</p>
    <p class="text-2xl text-green-600 font-bold">+8801812345678</p>
    <a href="{{ route('homepage') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Continue Shopping
    </a>
</div>
@endsection
