@php
    $contact_settings = App\Models\ContactSetting::first();
    $social_media_settings = App\Models\SocialMediaSetting::first();

    $companyEmail = $contact_settings->email ?? null;
    $companyPhone = $contact_settings->phone ?? null;
    $address = $contact_settings->address ?? null;

    $facebook = $social_media_settings->facebook ?? null;
    $twitter = $social_media_settings->twitter ?? null;
    $instagram = $social_media_settings->instagram ?? null;
    $linkedin = $social_media_settings->linkedin ?? null;
    $youtube = $social_media_settings->youtube ?? null;

@endphp

<footer class="bg-white text-black px-6 md:px-12 lg:px-20 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 border-t pt-12">
        <!-- Get In Touch -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Get In Touch</h2>
            <ul class="space-y-2 text-sm">
                <li class="flex items-start gap-2">
                    <i class="fa fa-globe mt-1"></i>
                    <span>{{ $address }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:{{ $companyEmail }}" class="hover:underline break-words">{{ $companyEmail }}</a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fa fa-phone"></i>
                    <span>{{ $companyPhone }}</span>
                </li>
            </ul>
            <div class="flex space-x-4 mt-4 text-xl">
                <a target="_blank" href="{{ $facebook }}" class="hover:text-orange-500"><i
                        class="fab fa-facebook"></i></a>
                <a target="_blank" href="{{ $twitter }}" class="hover:text-orange-500"><i
                        class="fab fa-twitter"></i></a>
                <a target="_blank" href="{{ $instagram }}" class="hover:text-orange-500"><i
                        class="fab fa-instagram"></i></a>
                <a target="_blank" href="{{ $linkedin }}" class="hover:text-orange-500"><i
                        class="fab fa-linkedin"></i></a>
                <a target="_blank" href="{{ $youtube }}" class="hover:text-orange-500"><i
                        class="fab fa-youtube"></i></a>
            </div>
        </div>

        <!-- Shop -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Shop</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">About Us</a></li>
                <li><a href="{{ route('contact_us') }}" class="hover:underline">Contact Us</a></li>
                <li><a href="{{ route('faq') }}" class="hover:underline">FAQ</a></li>
                <li><a href="#" class="hover:underline">Payment Method</a></li>
            </ul>
        </div>

        <!-- Policy -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Policy</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('return_policy') }}" class="hover:underline">Return Policy</a></li>
                <li><a href="{{ route('shipping_policy') }}" class="hover:underline">Shipping Policy</a></li>
                <li><a href="{{ route('privacy_policy') }}" class="hover:underline">Privacy Policy</a></li>
                <li><a href="#" class="hover:underline">Cookie Policy</a></li>
                <li><a href="#" class="hover:underline">Terms & Conditions</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Subscribe to our newsletter</h2>
            <form class="flex flex-row md:flex-col sm:items-center !items-start gap-3" action="{{ route('subscribers.store') }}"
                method="POST" id="subscriberForm">
                @csrf
                <input type="email" name="email" id="subscriber_email" placeholder="Your email address"
                    class="flex-1 border border-gray-300 px-4 py-2 rounded outline-none w-full sm:w-auto" />
                <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 w-full sm:w-auto">
                    Subscribe
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="mt-10 border-t pt-6 text-center text-sm">
        <p>Copyright © 2025 All rights reserved.</p>
    </div>
</footer>

<script>
    $(document).ready(function() {
        // $('#subscriberForm').on('submit', function(e) {
        $(document).on('click', '.subscriber_form_submit', function(e) {
            e.preventDefault();

            let form = $('#subscriberForm');
            let url = form.attr('action');
            let email = $('#subscriber_email').val();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: $('input[name=_token]').val(),
                    email: email
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#subscriberForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation error
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                        $('#subscriberForm')[0].reset();
                    } else {
                        toastr.error('Something went wrong!');
                        $('#subscriberForm')[0].reset();
                    }
                }
            });
        });

        let currentLang = "{{ session('lang', 'en') }}";

        const languages = {
            'en': '🇬🇧',
            'pt': '🇵🇹',
            'ar': '🇸🇦',
            'es': '🇪🇸',
            'fr': '🇫🇷',
            'it': '🇮🇹',
            'de': '🇩🇪',
            'sv': '🇸🇪',
            'no': '🇳🇴',
            'tr': '🇹🇷',
            'hi': '🇮🇳',
            'ru': '🇷🇺',
            'el': '🇬🇷',
            'ro': '🇷🇴',
            'cs': '🇨🇿',
            'pl': '🇵🇱'
        };

        // ✅ Global CSRF
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        // store original texts
        $("[data-translate]").each(function() {
            if (!$(this).data("original")) {
                $(this).data("original", $(this).text().trim());
            }
        });

        // show dropdown menu
        $('#languageToggle').on('click', function() {
            $('#languageMenu').toggleClass('hidden');
        });

        // select a language from dropdown
        $('#languageMenu button').on('click', function() {
            let newLang = $(this).data('lang');
            if (newLang === currentLang) return;

            showLoading(true);

            $.ajax({
                url: "{{ route('switchLanguage') }}",
                type: "POST",
                data: {
                    language: newLang
                },
                success: function() {
                    // Update toggle button text and flag
                    $('#currentLanguage').text(newLang.toUpperCase());
                    $('#languageToggle span:first').text(languages[newLang]);

                    // Translate page content
                    translatePageContent(newLang);

                    // update currentLang
                    currentLang = newLang;

                    // close dropdown
                    $('#languageMenu').addClass('hidden');
                },
                error: function() {
                    console.error("Translation failed");
                },
                complete: function() {
                    showLoading(false);
                }
            });
        });

        $('#languageSelect').on('change', function() {
            let newLang = $(this).val();
            if (newLang === currentLang) return;

            showLoading(true);

            $.ajax({
                url: "{{ route('switchLanguage') }}",
                type: "POST",
                data: {
                    language: newLang,
                    _token: "{{ csrf_token() }}" // important for POST
                },
                success: function() {
                    // Update toggle text/flag
                    $('#currentLanguage').text(newLang.toUpperCase());
                    $('#languageToggle span:first').text(languages[newLang]);

                    // Translate page content dynamically
                    translatePageContent(newLang);

                    // update currentLang
                    currentLang = newLang;
                },
                error: function() {
                    console.error("Translation failed");
                },
                complete: function() {
                    showLoading(false);
                }
            });
        });


        // translate page content
        function translatePageContent(language) {
            let elements = $("[data-translate]");

            if (language === "en") {
                elements.each(function() {
                    animateTextChange($(this), $(this).data("original"));
                });
                return;
            }

            let textsToTranslate = [];
            elements.each(function() {
                textsToTranslate.push($(this).data("original"));
            });

            let chunkSize = 50;
            for (let i = 0; i < textsToTranslate.length; i += chunkSize) {
                let chunk = textsToTranslate.slice(i, i + chunkSize);
                let chunkIndex = i / chunkSize;

                $.ajax({
                    url: "{{ route('translateTexts') }}",
                    type: "POST",
                    data: {
                        texts: chunk,
                        language: language
                    },
                    success: function(data) {
                        if (data.success) {
                            Object.keys(data.translations).forEach((j) => {
                                let globalIndex = chunkIndex * chunkSize + parseInt(j);
                                if (data.translations[j]) {
                                    animateTextChange($(elements[globalIndex]), data
                                        .translations[j]);
                                }
                            });
                        }
                    }
                });
            }
        }

        // animate text change
        function animateTextChange($el, newText) {
            $el.css({
                transition: "opacity 0.15s",
                opacity: "0.3"
            });
            setTimeout(function() {
                $el.text(newText).css("opacity", "1");
            }, 150);
        }

        // loading indicator
        function showLoading(show) {
            let $indicator = $("#loadingIndicator");
            let $toggle = $("#languageToggle");

            $indicator.toggleClass("hidden", !show);
            $toggle.prop("disabled", show);
        }

        $(".variant-thumb").each(function() {
            var $thumb = $(this);
            var mainId = $thumb.data("main-image");
            var $mainImg = $("#" + mainId);

            $thumb.on("mouseenter", function() {
                // Fade out
                $mainImg.addClass("opacity-0");

                // Swap image after short delay
                setTimeout(function() {
                    $mainImg.attr("src", $thumb.data("variant-src"));
                    // Fade in
                    $mainImg.removeClass("opacity-0");
                }, 200); // matches your transition duration
            });
        });
    });
</script>
