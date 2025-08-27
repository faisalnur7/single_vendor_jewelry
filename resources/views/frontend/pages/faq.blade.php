@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')
@section('contents')

<section class="mt-24 pt-0 pb-12 px-6">
    <div class="mx-auto max-w-6xl">
        <h2 class="text-2xl text-center font-semibold mb-6">FAQ</h2>

        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div class="border rounded-lg shadow-sm">
                    <button class="faq-toggle w-full flex justify-between items-center p-4 text-left">
                        <span class="font-medium">{{ $faq->question }}</span>
                        <svg class="h-5 w-5 text-gray-500 plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        <svg class="h-5 w-5 text-gray-500 minus-icon hidden" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 12H4"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden p-4 border-t text-gray-600">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $(".faq-toggle").on("click", function () {
            let content = $(this).next(".faq-content");

            // Close others
            $(".faq-content").not(content).slideUp().prev().find(".minus-icon").addClass("hidden");
            $(".faq-content").not(content).prev().find(".plus-icon").removeClass("hidden");

            // Toggle current
            content.slideToggle();
            $(this).find(".plus-icon").toggleClass("hidden");
            $(this).find(".minus-icon").toggleClass("hidden");
        });
    });
</script>
@endsection
