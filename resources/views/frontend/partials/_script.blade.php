<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"

    }
</script>
<script>
    // Title bouncer
    document.addEventListener("DOMContentLoaded", function() {
        const originalTitle = document.title;
        const spacer = " - "; // More spaces = smoother transition
        const scrollText = originalTitle + spacer;
        let scrollIndex = 0;
        const speed = 200; // Lower is faster (try 100 or 80 for very smooth)

        function smoothMarquee() {
            const part1 = scrollText.substring(scrollIndex);
            const part2 = scrollText.substring(0, scrollIndex);
            document.title = part1 + part2;

            scrollIndex = (scrollIndex + 1) % scrollText.length;
            setTimeout(smoothMarquee, speed);
        }

        smoothMarquee();
    });

    // Open Login Drawer
    function openLogin() {
        $('#loginDrawer').removeClass('hidden');
        $('body').addClass('overflow-hidden pr-[16px]');

        // Default to login form
        showLogin();

        setTimeout(function () {
            $('#loginBackdrop').removeClass('opacity-0').addClass('opacity-100');
            $('#loginPanel').removeClass('translate-x-full').addClass('translate-x-0');
        }, 10);
    }

    // Close Login Drawer
    function closeLogin() {
        $('#loginBackdrop').removeClass('opacity-100').addClass('opacity-0');
        $('#loginPanel').removeClass('translate-x-0').addClass('translate-x-full');

        setTimeout(function () {
            $('#loginDrawer').addClass('hidden');
            $('body').removeClass('overflow-hidden pr-[16px]');
        }, 500); // Match transition duration
    }

    // Show Login Form
    function showLogin() {
        $('#drawerTitle').text('Login');
        $('#registerForm').fadeOut(200, function () {
            $('#loginForm').fadeIn(200);
            $('#email').trigger('focus');
        });
    }

    // Show Register Form
    function showRegister() {
        $('#drawerTitle').text('Register');
        $('#loginForm').fadeOut(200, function () {
            $('#registerForm').fadeIn(200);
            $('#name').trigger('focus');
        });
    }

    $(document).ready(function () {
        // Bind click event on checkout triggers
        $('.checkout-trigger').on('click', function (e) {
            @if (!auth()->check())
                e.preventDefault();
                openLogin();
            @endif
        });

        // Backdrop click
        $('#loginBackdrop').on('click', function () {
            closeLogin();
        });

        // ESC key closes login drawer
        $(document).on('keydown', function (e) {
            if (e.key === "Escape") {
                closeLogin();
            }
        });

        // Close icon triggers close
        $('.close-login').on('click', function () {
            closeLogin();
        });

        // Toggle to register/login manually
        $(document).on('click', '.toggle-register', function () {
            showRegister();
        });

        $(document).on('click', '.toggle-login', function () {
            showLogin();
        });
    });

</script>
