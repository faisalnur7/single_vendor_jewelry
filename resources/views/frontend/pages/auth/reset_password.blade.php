@extends('frontend.layouts.main')
@section('title', 'Reset Password')

@section('contents')
<section class="pt-0 pb-12">
    <div class="bg-gray-600 text-white py-12 text-center text-xl tracking-widest uppercase font-medium">
        Reset Password
    </div>

    <div class="flex justify-center items-center py-36 px-4 signin_signup_form">
        <form method="POST" action="{{ route('user.password.update') }}" class="w-full max-w-sm space-y-4">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="mb-4 relative">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $email) }}"
                    required
                    autofocus
                    class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600"
                    placeholder=" "
                />
                <label class="floating-label">Email Address</label>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4 relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600"
                    placeholder=" "
                />
                <label class="floating-label">New Password</label>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4 relative">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600"
                    placeholder=" "
                />
                <label class="floating-label">Confirm New Password</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">
                Reset Password
            </button>
        </form>
    </div>
</section>
@endsection
