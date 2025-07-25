<!-- Sliding Login/Register Form -->
<div id="loginDrawer" class="fixed top-0 left-0 w-full h-full z-50 hidden">
    <!-- Backdrop -->
    <div id="loginBackdrop" class="absolute inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-500"
        onclick="closeLogin()"></div>

    <!-- Panel -->
    <div class="absolute top-0 right-0 h-full w-full md:w-[320px] lg:w-[320px] bg-white shadow-lg transform transition-transform duration-500 ease-in-out translate-x-full"
        id="loginPanel">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <h2 id="drawerTitle" class="text-lg font-semibold">LOGIN</h2>
            <button onclick="closeLogin()"
                class="text-gray-900 hover:text-gray-950 text-md font-extralight transition-transform duration-300 ease-in-out hover:rotate-180">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- LOGIN FORM -->
        <form id="loginForm" method="POST" action="{{ route('login') }}" class="p-6 space-y-2">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full border rounded px-4 py-2 mt-1" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full border rounded px-4 py-2 mt-1" />
            </div>

            <p class="text-sm text-gray-500 mt-0">
                <a href="{{ route('password.request') }}" class="text-gray-900 hover:underline">Forgot your
                    password?</a>
            </p>

            <button type="submit" class="w-full bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">
                Login
            </button>

            <p class="text-sm text-gray-950 mt-2">
                New customer? <button type="button" onclick="showRegister()" class="hover:underline">Create your
                    account</button>
            </p>
        </form>

        <!-- REGISTER FORM -->
        <form id="registerForm" method="POST" action="{{ route('register') }}" class="p-6 space-y-2 hidden">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" required
                    class="w-full border rounded px-4 py-2 mt-1" />
            </div>
            <div>
                <label for="email_register" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email_register" required
                    class="w-full border rounded px-4 py-2 mt-1" />
            </div>
            <div>
                <label for="password_register" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password_register" required
                    class="w-full border rounded px-4 py-2 mt-1" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full border rounded px-4 py-2 mt-1" />
            </div>

            <button type="submit" class="w-full bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">
                Register
            </button>

            <p class="text-sm text-gray-950 mt-2">
                Already have an account? <button type="button" onclick="showLogin()" class="hover:underline">Login
                    here</button>
            </p>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const data = form.serialize();

            // Clear previous error messages
            form.find('.text-red-500').remove();
            $('#loginButton').prop('disabled', true).text('Logging in...');

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function (response) {
                    console.log('Login successful:', response);
                    if (document.referrer && document.referrer !== location.href) {
                        window.location.href = document.referrer;
                    } else {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;
                    const errors = res?.errors || {};
                    const message = res?.message || "Login failed.";

                    // General error message
                    if (!$.isEmptyObject(errors)) {
                        for (const [field, messages] of Object.entries(errors)) {
                            const input = form.find(`[name="${field}"]`);
                            if (input.length) {
                                input
                                    .after(
                                        `<p class="text-red-500 text-sm mt-1">${messages[0]}</p>`
                                        );
                            }
                        }
                    } else {
                        alert(message);
                    }

                    // Re-enable button
                    $('#loginButton').prop('disabled', false).text('Login');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#registerForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const data = form.serialize();

            // Clear previous error messages
            form.find('.text-red-500').remove();
            $('#registerForm button[type="submit"]').prop('disabled', true).text('Registering...');

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function (response) {
                    console.log('Registration successful:', response);
                    location.reload(); // Stay on the same page after registration and login
                },
                error: function (xhr) {
                    const res = xhr.responseJSON;
                    const errors = res?.errors || {};
                    const message = res?.message || "Registration failed.";

                    if (!$.isEmptyObject(errors)) {
                        for (const [field, messages] of Object.entries(errors)) {
                            const input = form.find(`[name="${field}"]`);
                            if (input.length) {
                                input.after(`<p class="text-red-500 text-sm mt-1">${messages[0]}</p>`);
                            }
                        }
                    } else {
                        alert(message);
                    }

                    $('#registerForm button[type="submit"]').prop('disabled', false).text('Register');
                }
            });
        });
    });
</script>
