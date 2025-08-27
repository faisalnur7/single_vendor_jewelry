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

<footer class="bg-white text-black px-6 md:px-20 py-10">
    <div class="grid md:grid-cols-4 gap-8 border-t pt-12">
        <!-- Get In Touch -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Get In Touch</h2>
            <ul class="space-y-2 text-sm">
                <li class="flex items-start"><span class="mr-2">📧</span> General Info: <a
                        href="mailto:{{ $companyEmail }}" class="ml-1 hover:underline">{{ $companyEmail }}</a></li>
                <li class="flex items-center"><span class="mr-2">📞</span> {{ $companyPhone }}</li>
                <li>{{ $address }}</li>
            </ul>
            <div class="flex space-x-4 mt-4 text-xl">
                <a target="_blank" href="{{ $facebook }}"><i class="fab fa-facebook"></i></a>
                <a target="_blank" href="{{ $twitter }}"><i class="fab fa-twitter"></i></a>
                <a target="_blank" href="{{ $instagram }}"><i class="fab fa-instagram"></i></a>
                <a target="_blank" href="{{ $linkedin }}"><i class="fab fa-linkedin"></i></a>
                <a target="_blank" href="{{ $youtube }}"><i class="fab fa-youtube"></i></a>
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
                <li><a href="#" class="hover:underline">Terms and Conditions</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Subscribe to our newsletter</h2>
            <div class="flex flex-col space-y-2">
                <form class="flex flex-col space-y-2" action="{{ route('subscribers.store') }}" method="POST"
                    id="subscriberForm">
                    @csrf
                    <input type="email" name="email" id="subscriber_email" placeholder="Your email address"
                        class="border border-gray-300 px-4 py-2 rounded outline-none" />
                    <button type="submit"
                        class="bg-black text-white py-2 rounded hover:bg-gray-800 subscriber_form_submit">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="mt-10 border-t pt-6 text-center text-sm">
        <p>Copyright © 2025 all rights reserved.</p>
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
    });
</script>
