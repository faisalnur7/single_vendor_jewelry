@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')

@section('contents')
    <section class="pt-0 pb-12">
        <div class="bg-gray-600 text-white py-12 text-center text-xl tracking-widest font-medium">
            Register
        </div>

        <!-- Login Form Section -->
        <div class="flex justify-center items-center py-36 px-4 transition_label_form">
            <div class="w-full max-w-xl space-y-6">
                <!-- ✅ FORM Starts -->
                <form id="register_form" class="w-full max-w-sm" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="form-group mb-6">
                        <input type="text" name="name" required placeholder=" "
                            class="peer w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600" />
                        <label class="floating-label">Full Name</label>
                    </div>

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

                    <!-- Password Confirmation -->
                    <div class="form-group mb-6">
                        <input type="password" name="password_confirmation" required placeholder=" "
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none" />
                        <label class="floating-label">Confirm Password</label>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit"
                        class="w-full bg-gray-200 text-gray-900 py-2 rounded-md hover:bg-gray-800 hover:text-white">
                        Register
                    </button>
                </form>

                <!-- Forgot Password -->
                <div class="text-sm mt-4">
                    <a href="{{ route('signin') }}" class="text-gray-700 underline">Already have an account? Login here</a>
                </div>

                @if (false)
                    <!-- OR Divider -->
                    <div class="flex items-center gap-4 mt-6">
                        <div class="flex-1 h-px bg-gray-300"></div>
                        <span class="text-gray-500 text-sm">OR</span>
                        <div class="flex-1 h-px bg-gray-300"></div>
                    </div>

                    <!-- Social Logins -->
                    <div class="flex flex-wrap justify-center gap-4 text-sm items-center mt-6">
                        <a href="{{ route('social.redirect', 'google') }}" class="flex items-center gap-2">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/google.svg" class="w-5 h-5"> Google
                        </a>
                        <a href="{{ route('social.redirect', 'facebook') }}" class="flex items-center gap-2">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/facebook.svg" class="w-5 h-5">
                            Facebook
                        </a>
                        <a href="{{ route('social.redirect', 'apple') }}" class="flex items-center gap-2 px-3 py-1 rounded">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/apple.svg" class="w-5 h-5"> Apple
                        </a>
                        <a href="{{ route('social.redirect', 'tiktok') }}" class="flex items-center gap-2">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/tiktok.svg" class="w-5 h-5"> TikTok
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#register_form').on('submit', function(e) {
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
