@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')

@section('contents')
    <section class="pt-0 pb-12">
        <div class="bg-gray-600 text-white py-12 text-center text-xl tracking-widest uppercase font-medium">
            Login
        </div>

        <!-- Login Form Section -->
        <div class="flex justify-center items-center py-36 px-4 signin_signup_form">

            <form id="register_form" action="{{ route('send_reset_password_link') }}" method="POST">
                @csrf
                <div class="w-full max-w-sm space-y-4">
                    <h2 class="text-2xl font-bold">Reset your password</h2>
                    <p>Lost your password? Please enter your email address. You will receive a link to create a new password
                        via email.</p>
                    <!-- Email -->
                    <div class="form-group mb-6">
                        <input type="email" name="email" required placeholder=" "
                            class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600" />
                        <label class="floating-label">Email</label>
                    </div>

                    <!-- Sign In Button -->
                    <button class="w-full bg-black text-white py-2 rounded-full hover:bg-gray-800">
                        Send Password Reset Link
                    </button>

                    <!-- Create Account -->
                    <div class="text-sm text-center">
                        <a href="{{ route('signin') }}" class="text-gray-800 underline">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('scripts')

@endsection
