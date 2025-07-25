@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry - User Profile')

@section('contents')
    <div class="w-full pt-8 bg-gradient-to-br from-orange-50 via-white to-white min-h-screen text-gray-800">
        <div class="mx-auto w-full max-w-[1440px] flex flex-col lg:flex-row px-4 sm:px-6 lg:px-8 py-6 gap-8">
            <div class="flex-1 w-full">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <!-- Left Column - Contact Form -->
                        <div class="p-6 sm:p-8 lg:p-12">
                            <h2 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-6 sm:mb-8">
                                Do you have questions for us?
                            </h2>

                            <form method="POST" action="{{ route('contact_us_messages') }}" id="contactForm"
                                class="space-y-6 transition_label_form">
                                @csrf
                                <!-- Name -->
                                <div class="form-group relative">
                                    <input type="text" name="name" required placeholder=" "
                                        class="peer w-full border border-gray-300 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    <label
                                        class="floating-label absolute left-4 top-3 text-gray-500 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-600">
                                        Full Name
                                    </label>
                                </div>

                                <!-- Email -->
                                <div class="form-group relative">
                                    <input type="email" name="email" required placeholder=" "
                                        class="peer w-full border border-gray-300 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    <label
                                        class="floating-label absolute left-4 top-3 text-gray-500 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-600">
                                        Email
                                    </label>
                                </div>

                                <!-- Company -->
                                <div class="form-group relative">
                                    <input type="text" name="company" placeholder=" "
                                        class="peer w-full border border-gray-300 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    <label
                                        class="floating-label absolute left-4 top-3 text-gray-500 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-600">
                                        Company
                                    </label>
                                </div>

                                <!-- Message -->
                                <div class="form-group relative">
                                    <textarea name="message" rows="6" placeholder=" "
                                        class="peer w-full border border-gray-300 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical"></textarea>
                                    <label
                                        class="floating-label absolute left-4 top-3 text-gray-500 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-600">
                                        Message
                                    </label>
                                </div>

                                <!-- Submit -->
                                <div>
                                    <button type="submit"
                                        class="w-full sm:w-auto bg-gray-900 text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column - Customer Support Info -->
                        <div class="bg-gray-100 p-6 sm:p-8 lg:p-12">
                            <h2 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-6 sm:mb-8">
                                24/7 Customer Support
                            </h2>

                            <div class="space-y-8 text-sm sm:text-base">
                                <!-- Support Email -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 underline">For Customer Support</h3>
                                    <p class="text-gray-700">{{ $contact_settings->customer_support_email }}</p>
                                </div>

                                <!-- General Info -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 underline">For General Info</h3>
                                    <p class="text-gray-700">{{ $contact_settings->email }}</p>
                                </div>

                                <!-- Phone / WhatsApp -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 underline">Call us at</h3>
                                    <p class="text-gray-700 mb-1">{{ $contact_settings->phone }}</p>
                                    <a class="whatsapp-link text-blue-600 font-medium underline cursor-pointer hover:text-blue-700"
                                        data-phone="{{ $contact_settings->phone }}">
                                        Chat via WhatsApp
                                    </a>
                                    <p class="text-gray-700 mt-2">{{ $contact_settings->whatsapp }}</p>
                                </div>

                                <!-- Address -->
                                <div>
                                    <p class="text-gray-700">{{ $contact_settings->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                // Add form submission handling
                $('#contactForm').on('submit', function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const url = form.attr('action');
                    const data = form.serialize();

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: data,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            toastr.success('Message sent');
                        },
                        error: function(xhr) {
                            const res = xhr.responseJSON;
                            const errors = res?.errors || {};
                            const message = res?.message || "Registration failed.";

                            if (!$.isEmptyObject(errors)) {
                                for (const [field, messages] of Object.entries(errors)) {
                                    const input = form.find(`[name="${field}"]`);
                                    if (input.length) {
                                        input.after(
                                            `<p class="text-red-500 text-sm mt-1">${messages[0]}</p>`
                                        );
                                    }
                                }
                            } else {
                                alert(message);
                            }

                            form.find('button[type="submit"]').prop('disabled', false).text(
                                'Register');
                        }
                    });

                    // Reset form
                    this.reset();
                });

                // Add WhatsApp click functionality
                $('.whatsapp-link').on('click', function(e) {
                    e.preventDefault();
                    const phone = $(this).data('phone');
                    window.open('https://wa.me/' + phone, '_blank');
                });
            });
        </script>

    @endsection
