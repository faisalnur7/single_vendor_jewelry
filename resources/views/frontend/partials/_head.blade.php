<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title')</title>

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
<style>
    body {
        /*font-family: "Playfair Display", serif; */
        font-family: "Playfair Display", serif !important;
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
</style>

@vite('resources/css/app.css')
