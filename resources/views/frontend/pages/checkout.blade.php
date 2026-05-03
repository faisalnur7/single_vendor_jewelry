@extends('frontend.layouts.checkout_template')
@section('title', 'Checkout')
@section('head_scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('contents')

    <section class="bg-transparent font-arial">
        <div class="w-full mx-auto flex justify-center flex-col-reverse md:flex-row">
            <!-- Left: Checkout Form (Scrollable) -->
            <div class="w-full bg-white p-6 flex justify-center md:justify-end">
                <div class="w-full max-w-[500px] bg-white p-0 md:p-6">
                    <!-- Express Checkout -->
                    <h2 class="text-md font-semibold text-center mb-4">Express checkout</h2>
                    <div class="flex gap-4 mb-6 justify-between">
                        <div id="google-pay-button-container"
                            class="flex w-full justify-center items-center gap-2 bg-black text-white hover:bg-gray-800 rounded font-semibold">
                            <img src="{{ asset('assets/img/payment_icons/gpay.png') }}" alt="GPay"
                                class="w-auto h-9 flex justify-center items-center p-2">
                        </div>
                    </div>

                    <div class="flex items-center my-3">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-4 text-sm text-gray-500 font-semibold">OR</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <div class="py-4 space-y-4">
                        <!-- Account -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Account</label>
                            <p class="text-gray-800">
                                @if (!empty(auth()->user()))
                                    {{ auth()->user()->email }}
                                @endif
                            </p>
                        </div>

                        <div class="flex items-start space-x-3 mt-4">
                            <input type="checkbox" id="marketing_opt_in" name="marketing_opt_in" checked
                                class="w-5 h-5 text-[#1773b0] border-gray-300 rounded focus:ring-blue-500" />
                            <label for="marketing_opt_in" class="text-sm text-gray-700 font-medium leading-5">
                                Email me with news and offers
                            </label>
                        </div>

                        <!-- Delivery -->
                        <div class="bg-gray-100 rounded-md border p-4 shadow-sm mb-6">
                            <h2 class="text-lg font-semibold mb-4">Delivery</h2>
                            <form id="payment-form" method="POST" action="{{ route('payment.process') }}">
                                @csrf

                                <!-- Name -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">First name (optional)</label>
                                        <input type="text" name="first_name"
                                            class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Last name</label>
                                        <input type="text" name="last_name"
                                            class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Address</label>
                                    <div class="relative">
                                        <input type="text" name="address"
                                            class="w-full border-gray-300 rounded px-4 py-2 pr-10 focus:ring-blue-500 focus:border-blue-500" />
                                        <span class="absolute top-2.5 right-3 text-gray-400">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Apartment -->
                                <div class="mb-4">
                                    <input type="text" name="apartment"
                                        class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Apartment, suite, etc. (optional)" />
                                </div>

                                <div class="mb-4">
                                    <label for="country" class="block text-sm font-medium mb-1">Country/Region</label>
                                    <select id="country" class="select2 w-full" name="country" required
                                        autocomplete="shipping country"
                                        class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->emoji }} {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- City, State, ZIP -->
                                <div class="grid grid-rows-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">State</label>
                                        <select name="state" id="state"
                                            class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">City</label>
                                        <select name="city" id="city"
                                            class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">ZIP code</label>
                                        <input type="text" name="zip"
                                            class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="mb-4 relative">
                                    <label class="block text-sm font-medium mb-1">Phone</label>
                                    <input type="text" name="phone" id="phone" required
                                        class="w-full border-gray-300 rounded px-4 py-2 pr-10 focus:ring-blue-500 focus:border-blue-500" />
                                    <span class="absolute top-2.5 right-3 text-gray-400">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                        </div>

                        <div>
                            <h3 class="font-bold text-lg mb-4">Select Shipping Method</h3>
                            <div class="flex gap-2 flex-col md:flex-row w-full p-2 border rounded-md" id="shipping-methods">
                                @foreach ($shippingMethods as $method)
                                    <label
                                        class="shipping-option group flex flex-col items-center gap-2 p-4 border rounded-lg cursor-pointer transition hover:bg-gray-200 relative w-full md:w-40 text-center">
                                        <input type="radio" class="hidden peer" name="shipping_method_id"
                                            value="{{ $method->id }}" required>
                                        <img src="{{ $method->logo }}"
                                            class="h-8 max-w-40 md:w-auto object-contain p-[3px]" />
                                        <div
                                            class="absolute inset-0 bg-gray-200 opacity-0 peer-checked:opacity-100 rounded-lg transition-all duration-200 -z-10">
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Card Payment Section --}}
                        <div>
                            <h3 class="font-bold text-lg mb-4">Checkout with Cards</h3>
                            <div class="py-4 border border-gray-100 bg-gray-100 p-4 rounded-md">
                                <input type="hidden" name="amount" value="{{ $total }}">
                                <input type="hidden" name="payment_intent_id" id="payment_intent_id">

                                <div id="card-container" class="mt-0">
                                    @php
                                        $paymentIcons = ['visa', 'master', 'american_express', 'discover', 'jcb', 'maestro'];
                                        $payment_image_class = 'w-12 h-8 object-contain border border-gray-300 rounded-md';
                                    @endphp

                                    <div class="flex flex-col md:flex-row justify-start md:justify-between items-start md:items-center pb-4 gap-2 md:gap-0">
                                        <span class="font-bold text-md">Pay with</span>
                                        <div class="flex items-center justify-start flex-wrap gap-1">
                                            @foreach ($paymentIcons as $icon)
                                                <img src="{{ asset('assets/img/payment_icons/' . $icon . '.svg') }}"
                                                    title="{{ ucwords(str_replace('_', ' ', $icon)) }}"
                                                    class="{{ $payment_image_class }}" />
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="pb-4">
                                        <div id="card-number"
                                            class="h-12 px-3 py-3 border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-blue-500 bg-white text-sm">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div id="expiration-date"
                                                class="h-12 px-3 py-3 border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-blue-500 bg-white text-sm">
                                            </div>
                                        </div>
                                        <div>
                                            <div id="cvv"
                                                class="h-12 px-3 py-3 border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-blue-500 bg-white text-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="card-errors" class="text-red-500 text-sm mt-2"></div>

                                <button type="submit" id="pay-btn"
                                    class="mt-4 w-full bg-[#1773b0] text-white py-2.5 rounded-md hover:bg-[#105989] transition-colors text-sm font-semibold disabled:opacity-60">
                                    Pay now
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary (Sticky) -->
            <div
                class="w-full static md:sticky top-0 bg-gray-100 p-6 h-min md:h-[100vh] border-l border-gray-300 flex justify-center md:justify-start font-arial">
                <div class="w-full max-w-[500px] bg-gray h-min md:h-[100vh] self-start">
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach ($cartItems as $item)
                            <div class="flex items-start gap-4 pt-4">
                                <div class="relative">
                                    <img src="{{ asset($item['image']) }}"
                                        class="w-16 h-16 border border-gray-300 object-cover rounded" />
                                    <span
                                        class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow">
                                        {{ $item['quantity'] }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium w-3/4" style="font-family: Arial, sans-serif;">
                                        {{ $item['product_name'] }}
                                    </p>
                                </div>
                                <p class="text-sm font-semibold">${{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-6 mt-6 border-t">
                        <div class="flex justify-between text-sm font-bold text-gray-900 mt-2">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.select2').select2({ placeholder: 'Select an option' });

            $('#shipping-methods input[type=radio]').on('change', function() {
                $('.shipping-option').removeClass('bg-gray-200');
                $(this).closest('.shipping-option').addClass('bg-gray-200');
            });

            $('#country').on('change', function() {
                const countryId = $(this).val();
                $('#state').html('<option value="">Loading...</option>').trigger('change');
                $('#city').html('<option value="">Select City</option>').trigger('change');
                if (countryId) {
                    $.ajax({
                        url: '/get-states/' + countryId,
                        type: 'GET',
                        success: function(states) {
                            let options = '<option value="">Select State</option>';
                            states.forEach(state => { options += `<option value="${state.id}">${state.name}</option>`; });
                            $('#state').html(options).trigger('change');
                        }
                    });
                }
            });

            $('#state').on('change', function() {
                const stateId = $(this).val();
                $('#city').html('<option value="">Loading...</option>').trigger('change');
                if (stateId) {
                    $.ajax({
                        url: '/get-cities/' + stateId,
                        type: 'GET',
                        success: function(cities) {
                            let options = '<option value="">Select City</option>';
                            cities.forEach(city => { options += `<option value="${city.id}">${city.name}</option>`; });
                            $('#city').html(options).trigger('change');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stripe = Stripe('{{ $stripeKey }}');
            const elements = stripe.elements();
            const totalAmount = {{ $total ?? 0 }};

            const style = {
                base: { fontSize: '16px', color: '#333', '::placeholder': { color: '#aab7c4' } },
                invalid: { color: '#e53e3e' }
            };

            const cardNumber = elements.create('cardNumber', { style });
            const cardExpiry = elements.create('cardExpiry', { style });
            const cardCvc   = elements.create('cardCvc',   { style });

            cardNumber.mount('#card-number');
            cardExpiry.mount('#expiration-date');
            cardCvc.mount('#cvv');

            [cardNumber, cardExpiry, cardCvc].forEach(el => {
                el.on('change', function (event) {
                    document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
                });
            });

            const form   = document.getElementById('payment-form');
            const payBtn = document.getElementById('pay-btn');

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const phone = document.getElementById('phone').value.trim();
                if (!phone) {
                    toastr.warning('Please enter your phone number before proceeding with payment.');
                    return;
                }

                payBtn.disabled = true;
                payBtn.textContent = 'Processing…';

                try {
                    // 1. Create PaymentIntent on server
                    const intentRes = await fetch('{{ route('payment.create_intent') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ amount: totalAmount })
                    });

                    const intentData = await intentRes.json();

                    if (!intentRes.ok || intentData.error) {
                        document.getElementById('card-errors').textContent = intentData.error || 'Could not initiate payment.';
                        payBtn.disabled = false;
                        payBtn.textContent = 'Pay now';
                        return;
                    }

                    // 2. Confirm card payment
                    const { paymentIntent, error } = await stripe.confirmCardPayment(intentData.clientSecret, {
                        payment_method: { card: cardNumber }
                    });

                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        payBtn.disabled = false;
                        payBtn.textContent = 'Pay now';
                        return;
                    }

                    // 3. Submit form with payment_intent_id
                    document.getElementById('payment_intent_id').value = paymentIntent.id;
                    form.submit();

                } catch (err) {
                    document.getElementById('card-errors').textContent = 'An unexpected error occurred.';
                    payBtn.disabled = false;
                    payBtn.textContent = 'Pay now';
                }
            });
        });
    </script>
@endsection
