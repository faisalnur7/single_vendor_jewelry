@extends('frontend.layouts.main')
@section('title', 'My Wishlist')

@section('contents')
    <div class="container mx-auto py-10">
        <h2 class="text-2xl text-center font-bold mb-6">FAQ</h2>

        <div id="guest-wishlist" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <p class="col-span-full text-gray-600 text-center">Loading your wishlist...</p>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
