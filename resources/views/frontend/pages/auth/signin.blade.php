@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')

@section('contents')
    <section class="pt-0 pb-12">
        <div class="bg-gray-600 text-white py-12 text-center text-xl tracking-widest uppercase font-medium">
            Login
        </div>

        <!-- Login Form Section -->
        <div class="flex flex-col gap-6 justify-center items-center py-36 px-4 transition_label_form">

            @if (session('status'))
                <div class="text-xl text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            <form id="login_form" class="w-full max-w-md" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="w-full space-y-6">

                    <!-- Email -->
                    <div class="form-group mb-6">
                        <input type="email" name="email" required placeholder=" "
                            class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600" />
                        <label class="floating-label">Email</label>
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-6">
                        <input type="password" name="password" required placeholder=" "
                            class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600" />
                        <label class="floating-label">Password</label>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-sm">
                        <a href="{{ route('forgot_password') }}" class="text-gray-700 underline">Forgot your password?</a>
                    </div>

                    <!-- Sign In Button -->
                    <button class="w-full bg-black text-white py-2 rounded-full hover:bg-gray-800">
                        SIGN IN
                    </button>

                    <!-- Create Account -->
                    <div class="text-center text-sm">
                        <a href="{{ route('signup') }}" class="text-gray-800 underline">New customer? Create your
                            account</a>
                    </div>

                    @if (false)
                        <!-- OR Divider -->
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-px bg-gray-300"></div>
                            <span class="text-gray-500 text-sm">OR</span>
                            <div class="flex-1 h-px bg-gray-300"></div>
                        </div>

                        <!-- Social Logins -->
                        <div class="flex flex-wrap justify-center gap-4 text-sm items-center mt-6">
                            <a href="{{ route('social.redirect', 'google') }}" class="flex items-center gap-2">
                                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/google.svg" class="w-5 h-5">
                                Google
                            </a>
                            <a href="{{ route('social.redirect', 'facebook') }}" class="flex items-center gap-2">
                                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/facebook.svg" class="w-5 h-5">
                                Facebook
                            </a>
                            <a href="{{ route('social.redirect', 'apple') }}"
                                class="flex items-center gap-2  px-3 py-1 rounded">
                                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/apple.svg" class="w-5 h-5">
                                Apple
                            </a>
                            <a href="{{ route('social.redirect', 'tiktok') }}" class="flex items-center gap-2">
                                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/tiktok.svg" class="w-5 h-5">
                                TikTok
                            </a>
                        </div>
                    @endif
                </div>
            </form>

        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#login_form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const data = form.serialize();

                // Clear previous error messages
                form.find('.text-red-500').remove();
                form.find('button[type="submit"]').prop('disabled', true).text('Registering...');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        console.log('Registration successful:', response);
                        window.location.href =
                            "{{ route('homepage') }}"; // Redirect after success
                    },
                    error: function(xhr) {
                        const res = xhr.responseJSON;
                        const errors = res?.errors || {};
                        const message = res?.message || "Registration failed.";

                        if (!$.isEmptyObject(errors)) {
                            for (const [field, messages] of Object.entries(errors)) {
                                const input = form.find(`[name="${field}"]`);
                                if (input.length) {
                                    input.after(
                                        `<p class="text-red-500 text-sm mt-1">${messages[0]}</p>`
                                    );
                                }
                            }
                        } else {
                            alert(message);
                        }

                        form.find('button[type="submit"]').prop('disabled', false).text(
                            'Register');
                    }
                });
            });
        });
    </script>
@endsection
