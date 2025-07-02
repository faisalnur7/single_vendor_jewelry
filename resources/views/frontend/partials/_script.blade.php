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
</script>
