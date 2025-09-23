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
        $(document).on('click','.checkout-trigger, .header-user-icon', function (e) {
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


        $(document).on('click', '.wishlist_btn', function(e) {
            e.preventDefault();
            let button = $(this);
            let productId = button.data('product_id');

            $.ajax({
                url: "{{ route('user_wishlist_store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                    } else if (response.error) {
                        toastr.warning(response.error);
                    } else if (response.guest) {
                        // Store in sessionStorage for guest users
                        let wishlist = JSON.parse(sessionStorage.getItem('wishlist')) || [];

                        if (wishlist.includes(productId)) {
                            toastr.warning("Product already in wishlist (guest).");
                        } else {
                            wishlist.push(productId);
                            sessionStorage.setItem('wishlist', JSON.stringify(wishlist));
                            toastr.success("Product added to wishlist (guest).");
                        }
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.error || "Something went wrong!");
                }
            });
        });

        // Only for guests (user not logged in)
        if (!@json(auth()->check())) {
            var wishlist = JSON.parse(sessionStorage.getItem('wishlist')) || [];
            $(".wishlist_count").text(wishlist.length > 0 ? wishlist.length : "");
            
            if(wishlist.length > 0){
                $(".wishlist_count").removeClass('bg-transparent');
                $(".wishlist_count").addClass('bg-red-500');
            }else{
                $(".wishlist_count").addClass('bg-transparent');
                $(".wishlist_count").removeClass('bg-red-500');
            }
        }

        // Optional: Update count dynamically when adding/removing
        $(document).on("click", ".wishlist_btn, .remove_guest_wishlist", function() {
            var wishlist = JSON.parse(sessionStorage.getItem('wishlist')) || [];
            $(".wishlist_count").text(wishlist.length > 0 ? wishlist.length : "");

            if(wishlist.length > 0){
                $(".wishlist_count").removeClass('bg-transparent');
                $(".wishlist_count").addClass('bg-red-500');
            }else{
                $(".wishlist_count").addClass('bg-transparent');
                $(".wishlist_count").removeClass('bg-red-500');
            }
        });

    });

    // jQuery on product page
    $(document).ready(function() {
        const productId = $('#pdpProductId').val(); // Hidden input or data attribute
        const maxItems = 10; // Number of products to show

        // Get stored products from localStorage
        let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed')) || [];

        // Remove if already exists to avoid duplicates
        recentlyViewed = recentlyViewed.filter(id => id != productId);

        // Add current product to the beginning
        recentlyViewed.unshift(productId);

        // Limit array to maxItems
        recentlyViewed = recentlyViewed.slice(0, maxItems);

        // Save back to localStorage
        localStorage.setItem('recentlyViewed', JSON.stringify(recentlyViewed));
    });
</script>
