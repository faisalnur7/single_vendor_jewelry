<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-900 mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L12 17h-1.098A4.915 4.915 0 0112 16c-2.796 0-5.303-.814-7.07-2.226l-.8-.8A5.973 5.973 0 0012 12a6 6 0 106 6c1.062 0 2.096-.276 2.986-.608l1.65-1.65A2 2 0 1115 7z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Create new password</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Your new password must be different from previously used passwords.
                </p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 animate-fade-in">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}" class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Field (readonly) -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        autocomplete="email"
                        readonly
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed"
                    />
                    <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        New Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        autocomplete="new-password"
                        placeholder="Enter your new password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 @error('password') border-red-500 focus:ring-red-500 @enderror"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm New Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your new password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                    />
                    <p id="password-match-hint" class="mt-1 text-xs hidden">
                        <span class="text-green-600">✓ Passwords match</span>
                        <span class="text-red-600 hidden">✗ Passwords do not match</span>
                    </p>
                </div>

                <!-- Password Strength Indicator -->
                <div id="password-strength-container" class="hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-gray-700">Password Strength</span>
                        <span id="strength-text" class="text-xs font-medium"></span>
                    </div>
                    <div class="flex space-x-1">
                        <div id="strength-bar-1" class="h-1 flex-1 rounded transition-colors"></div>
                        <div id="strength-bar-2" class="h-1 flex-1 rounded transition-colors"></div>
                        <div id="strength-bar-3" class="h-1 flex-1 rounded transition-colors"></div>
                        <div id="strength-bar-4" class="h-1 flex-1 rounded transition-colors"></div>
                    </div>
                    <ul id="password-requirements" class="mt-2 text-xs text-gray-500 space-y-1">
                        <li id="req-length" class="flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            At least 8 characters
                        </li>
                        <li id="req-uppercase" class="flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Uppercase letter
                        </li>
                        <li id="req-number" class="flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Number
                        </li>
                        <li id="req-special" class="flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Special character
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 font-semibold"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4-4m0 0l-4 4m4-4v12"/>
                    </svg>
                    Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Remember your password?
                    <a href="{{ route('login') }}" class="font-medium text-gray-900 hover:text-gray-700 transition-colors underline decoration-1 underline-offset-2">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Password strength bar colors */
        .strength-0 { background-color: #e5e7eb; }
        .strength-1 { background-color: #ef4444; }
        .strength-2 { background-color: #f59e0b; }
        .strength-3 { background-color: #10b981; }
        .strength-4 { background-color: #059669; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const strengthContainer = document.getElementById('password-strength-container');
            const strengthBars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3'),
                document.getElementById('strength-bar-4')
            ];
            const strengthText = document.getElementById('strength-text');
            const requirements = {
                length: document.getElementById('req-length'),
                uppercase: document.getElementById('req-uppercase'),
                number: document.getElementById('req-number'),
                special: document.getElementById('req-special')
            };

            function checkPasswordStrength(password) {
                let score = 0;
                const checks = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[^A-Za-z0-9]/.test(password)
                };

                // Update requirement icons
                Object.keys(checks).forEach((key) => {
                    if (checks[key]) {
                        requirements[key].classList.add('text-green-600');
                        requirements[key].classList.remove('text-gray-500');
                    } else {
                        requirements[key].classList.remove('text-green-600');
                        requirements[key].classList.add('text-gray-500');
                    }
                });

                // Calculate score (0-4)
                score = Object.values(checks).filter(v => v).length;

                // Update strength bars
                strengthBars.forEach((bar, index) => {
                    bar.className = 'h-1 flex-1 rounded transition-colors';
                    if (index < score) {
                        bar.classList.add(`strength-${score}`);
                    } else {
                        bar.classList.add('strength-0');
                    }
                });

                // Update strength text
                const strengthLabels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
                strengthText.textContent = strengthLabels[score] || '';
                strengthText.className = 'text-xs font-medium ' + 
                    (score <= 1 ? 'text-red-600' : 
                     score === 2 ? 'text-yellow-600' : 'text-green-600');

                if (password.length > 0) {
                    strengthContainer.classList.remove('hidden');
                } else {
                    strengthContainer.classList.add('hidden');
                }
            }

            function checkPasswordMatch() {
                if (confirmInput.value && passwordInput.value !== confirmInput.value) {
                    confirmInput.classList.add('border-red-500');
                    confirmInput.classList.remove('border-green-500');
                    document.getElementById('password-match-hint').querySelector('.text-green-600').classList.add('hidden');
                    document.getElementById('password-match-hint').querySelector('.text-red-600').classList.remove('hidden');
                    document.getElementById('password-match-hint').classList.remove('hidden');
                } else if (confirmInput.value && passwordInput.value === confirmInput.value) {
                    confirmInput.classList.remove('border-red-500');
                    confirmInput.classList.add('border-green-500');
                    document.getElementById('password-match-hint').querySelector('.text-green-600').classList.remove('hidden');
                    document.getElementById('password-match-hint').querySelector('.text-red-600').classList.add('hidden');
                    document.getElementById('password-match-hint').classList.remove('hidden');
                } else {
                    confirmInput.classList.remove('border-red-500', 'border-green-500');
                    document.getElementById('password-match-hint').classList.add('hidden');
                }
            }

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                    checkPasswordMatch();
                });
            }

            if (confirmInput) {
                confirmInput.addEventListener('input', checkPasswordMatch);
            }

            // Auto-focus password field on load
            setTimeout(() => {
                const tokenInput = document.querySelector('input[name="token"]');
                if (tokenInput) {
                    // Token is present, focus password
                    document.getElementById('password')?.focus();
                }
            }, 100);
        });
    </script>
</x-guest-layout>
