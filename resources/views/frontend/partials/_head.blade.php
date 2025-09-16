<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title')</title>

<link rel="icon" href="{{ asset($general_settings->site_favicon) }}" type="image/ico">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
    rel="stylesheet">
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- sweet alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    body {
        /*font-family: "Playfair Display", serif; */
        font-family: "Playfair Display", serif !important;
        zoom:0.98;
    }

    /* Make all bullets transparent by default */
    .swiper-pagination-bullet {
        background-color: black;
        border: 1px solid black;
        opacity: 0.2;
        width: 10px;
        height: 10px;
        margin: 0 4px !important;
    }

    /* Active bullet will be black */
    .swiper-pagination-bullet-active {
        background-color: black !important;
        color: black !important;
        opacity: 1;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: black !important;
    }

    .pdp_quantity {
        border: 1px solid;
        border-radius: 20px;
        justify-content: space-between;
        width: 100%;
        max-width: 100px;
        align-items: center;
        padding: 4px;
    }

    .pdp_quantity button {
        border: none;

    }

    .toast {
        background-color: #1f2937 !important;
        color: #f9fafb !important;
        font-size: 14px;
        border-left: 4px solid #10b981;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        flex-direction: row-reverse !important;
        justify-content: space-between !important;
    }

    /* Title (if used) */
    .toast-title {
        font-weight: 600;
    }

    /* Progress bar color */
    #toast-container>.toast.toast-success .toast-progress {
        background-color: #10b981 !important;
    }

    #toast-container>.toast.toast-error .toast-progress {
        background-color: #ef4444 !important;
    }

    #toast-container>.toast.toast-info .toast-progress {
        background-color: #3b82f6 !important;
    }

    #toast-container>.toast.toast-warning .toast-progress {
        background-color: #f59e0b !important;
    }

    /* Close button hover */
    .toast-close-button {
        color: #fff !important;
    }

    .toast-close-button:hover {
        color: #f87171 !important;
        /* red-400 */
    }

    .why_choose_us_list li {
        line-height: 2.5;
        font-size: 18px;
        font-family: 'arial';
    }

    .why_choose_us_list li::before {
        content: '🤎';
        margin-right: 10px;
    }

    .transition_label_form .form-group {
        position: relative;
    }

    .transition_label_form .floating-label {
        position: absolute;
        left: 1rem;
        top: 0.75rem;
        background-color: white;
        padding: 0 0.25rem;
        color: #6b7280;
        /* text-gray-500 */
        transition: all 0.2s ease;
        pointer-events: none;
        z-index: 10;
    }

    /* FIXED: Only sibling selector required */
    .transition_label_form input:focus+.floating-label,
    .transition_label_form input:not(:placeholder-shown)+.floating-label {
        top: -0.6rem;
        left: 0.75rem;
        font-size: 0.75rem;
        /* text-xs */
        color: #111827;
        /* text-gray-900 */
    }

    /* Spinner style */
    .loader {
        border: 6px solid #f3f3f3;
        /* Light gray */
        border-top: 6px solid #000;
        /* Black */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    /* Spin animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

@vite('resources/css/app.css')
