@extends('frontend.layouts.main')
@section('title', 'Reset Password')

@section('contents')
<section class="pt-0 pb-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="bg-gray-800 text-white py-12 text-center text-xl tracking-widest uppercase font-medium">
        Create New Password
    </div>

    <div class="flex justify-center items-center py-16 px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                        <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L12 17h-1.098A4.915 4.915 0 0112 16c-2.796 0-5.303-.814-7.07-2.226l-.8-.8A5.973 5.973 0 0012 12a6 6 0 106 6c1.062 0 2.096-.276 2.986-.608l1.65-1.65A2 2 0 1115 7z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Set a new password</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Your new password must be different from previously used passwords.
                    </p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <ul class="text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Reset Password Form -->
                <form method="POST" action="{{ route('user.password.update') }}" class="space-y-6">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Field (readonly) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $email) }}"
                            required
                            readonly
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed"
                        />
                        <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="Enter new password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-gray-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                        />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            placeholder="Confirm new password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-gray-500 focus:border-transparent transition"
                        />
                    </div>

                    <!-- Password Strength Indicator (Optional Enhancement) -->
                    <div id="password-strength" class="hidden">
                        <div class="flex items-center mb-2">
                            <span class="text-xs font-medium text-gray-700 mr-2">Strength:</span>
                            <div class="flex space-x-1">
                                <div class="h-2 w-8 rounded bg-red-500" id="strength-bar-1"></div>
                                <div class="h-2 w-8 rounded bg-yellow-500" id="strength-bar-2"></div>
                                <div class="h-2 w-8 rounded bg-green-500" id="strength-bar-3"></div>
                            </div>
                            <span class="text-xs ml-2" id="strength-text"></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200 font-medium"
                    >
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4-4m0 0V5a2 2 0 012-2h6a2 2 0 012 2v8m-4 0h4"/>
                        </svg>
                        Reset Password
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Remember your password?
                        <a href="{{ route('signin') }}" class="font-medium text-gray-900 hover:text-gray-700 transition">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthDiv = document.getElementById('password-strength');
        const strengthBars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3')
        ];
        const strengthText = document.getElementById('strength-text');

        function checkStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Map strength (0-5) to 1-3 bars
            let bars = 0;
            if (strength >= 2) bars = 1;
            if (strength >= 3) bars = 2;
            if (strength >= 4) bars = 3;

            let text = '';
            let colors = ['bg-red-500', 'bg-yellow-500', 'bg-green-500'];
            
            switch(bars) {
                case 0: text = ''; break;
                case 1: text = 'Weak'; break;
                case 2: text = 'Fair'; break;
                case 3: text = 'Strong'; break;
            }

            return { bars, text, colors };
        }

        function updateStrength() {
            const result = checkStrength(passwordInput.value);
            
            strengthBars.forEach((bar, index) => {
                bar.className = 'h-2 w-8 rounded';
                if (index < result.bars) {
                    bar.classList.add(result.colors[result.bars - 1] || 'bg-gray-300');
                } else {
                    bar.classList.add('bg-gray-200');
                }
            });

            strengthText.textContent = result.text;
            strengthText.className = 'text-xs ' + (result.bars === 3 ? 'text-green-600' : (result.bars === 2 ? 'text-yellow-600' : 'text-red-600'));

            if (result.bars > 0) {
                strengthDiv.classList.remove('hidden');
            } else {
                strengthDiv.classList.add('hidden');
            }
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', updateStrength);
        }

        // Confirm password matching indicator
        if (confirmInput) {
            confirmInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-green-500');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                }
            });
        }
    });
</script>
@endsection
