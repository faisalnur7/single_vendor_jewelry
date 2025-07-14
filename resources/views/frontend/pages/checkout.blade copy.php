@extends('frontend.layouts.checkout_template')
@section('title', 'Checkout')
@section('styles')
    <style>
        /* Hide scrollbar but allow scroll */
        .scroll-hidden {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
        }

        .scroll-hidden::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        /* For single select */
        .select2-container--default .select2-selection--single {
            height: auto;
            padding: 10px 12px;
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
        }

        .select2-selection__arrow {
            top: 10px !important;
            right: 10px !important;
        }
    </style>
@endsection
@section('contents')
    <section class="bg-transparent font-arial">
        <div class="w-full mx-auto flex justify-center">
            <!-- Left: Checkout Form (Scrollable) -->

            <div class="w-full bg-white p-6 flex justify-end">
                <div class="w-full max-w-[500px] bg-white p-6 ">
                    <!-- Express Checkout -->
                    <h2 class="text-md font-semibold text-center mb-4">Express checkout</h2>
                    <div class="flex gap-4 mb-6 justify-between">
                        <button
                            class="flex w-full justify-center items-center gap-2 bg-yellow-400 hover:bg-yellow-300 rounded font-semibold">
                            <img src="{{ asset('assets/img/payment_icons/paypal.png') }}" alt="PayPal"
                                class="w-auto h-11 flex justify-center items-center p-3">
                        </button>
                        <button
                            class="flex w-full justify-center items-center gap-2 bg-black text-white hover:bg-gray-800 rounded font-semibold">
                            <img src="{{ asset('assets/img/payment_icons/gpay.png') }}" alt="GPay"
                                class="w-auto h-11 flex justify-center items-center p-3">
                        </button>
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
                        <!-- DELIVERY SECTION -->
                        <div class="bg-white rounded shadow-sm mb-6">
                            <h2 class="text-lg font-semibold mb-4">Delivery</h2>
                            <form id="payment-form" method="POST" action="{{ route('payment.process') }}">

                                <!-- Country -->

                                <div class="mb-4">
                                    <label for="country" class="block text-sm font-medium mb-1">Country/Region</label>
                                    <select id="country" class="select2 w-full" name="country" required
                                        autocomplete="shipping country"
                                        class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

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

                                <!-- City, State, ZIP -->
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">City</label>
                                        <select name="city" id="city"
                                            class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">State</label>
                                        <select name="state" id="state"
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
                                    <input type="text" name="phone"
                                        class="w-full border-gray-300 rounded px-4 py-2 pr-10 focus:ring-blue-500 focus:border-blue-500" />
                                    <span class="absolute top-2.5 right-3 text-gray-400">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                        </div>

                        <!-- SHIPPING METHOD -->
                        <div class="bg-gray-100 p-4 rounded border text-sm text-gray-700">
                            <strong>Shipping method</strong>
                            <p class="text-gray-500 mt-2">Enter your shipping address to view available shipping methods.
                            </p>
                        </div>

                        @csrf

                        {{-- Delivery Section --}}
                        <div class="py-4 space-y-4">
                            {{-- Total & Hidden Amount --}}
                            <input type="hidden" name="amount" value="{{ $total }}">

                            {{-- Braintree Drop-In --}}
                            <div id="card-container" class="space-y-4">
                                <label class="block">
                                    <span class="text-sm font-medium">Card Number</span>
                                    <div id="card-number" class="border px-3 py-2 rounded"></div>
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">Expiration Date</span>
                                    <div id="expiration-date" class="border px-3 py-2 rounded"></div>
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">CVV</span>
                                    <div id="cvv" class="border px-3 py-2 rounded"></div>
                                </label>
                            </div>
                            <div id="card-errors" class="text-red-500 text-sm mt-2"></div>


                            <button type="submit"
                                class="mt-6 w-full bg-[#105989] text-white py-3 rounded hover:bg-[#105989] transition">
                                Pay now
                            </button>
                        </div>
                        </form>


                    </div>
                </div>
            </div>

            <!-- Right: Order Summary (Sticky) -->
            <div
                class="w-full sticky top-0 bg-gray-100 p-6 h-[100vh] border-l border-gray-300 flex justify-start font-arial">
                <div class="w-full max-w-[500px] bg-gray h-[100vh] self-start">
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach ($cartItems as $item)
                            <div class="flex items-start gap-4 pt-4">
                                <!-- Image with quantity badge -->
                                <div class="relative">
                                    <img src="{{ asset($item['image']) }}"
                                        class="w-16 h-16 border border-gray-300 object-cover rounded" />

                                    <!-- Quantity badge -->
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
            $('.select2').select2({
                placeholder: 'Select an option'
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
                            states.forEach(state => {
                                options +=
                                    `<option value="${state.id}">${state.name}</option>`;
                            });
                            $('#state').html(options).trigger('change');
                        }
                    });
                }
            });

            // On state change => fetch cities
            $('#state').on('change', function() {
                const stateId = $(this).val();

                $('#city').html('<option value="">Loading...</option>').trigger('change');

                if (stateId) {
                    $.ajax({
                        url: '/get-cities/' + stateId,
                        type: 'GET',
                        success: function(cities) {
                            let options = '<option value="">Select City</option>';
                            cities.forEach(city => {
                                options +=
                                    `<option value="${city.id}">${city.name}</option>`;
                            });
                            $('#city').html(options).trigger('change');
                        }
                    });
                }
            });
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('payment-form');
            const clientToken = "{{ $clientToken }}";
            const totalAmount = '{{ $total ?? 10.0 }}';

            braintree.client.create({
                authorization: clientToken
            }, function(clientErr, clientInstance) {
                if (clientErr) {
                    console.error('Client Error:', clientErr);
                    return;
                }

                // 1️⃣ Hosted Fields
                braintree.hostedFields.create({
                    client: clientInstance,
                    styles: {
                        'input': {
                            'font-size': '16px',
                            'color': '#333'
                        }
                    },
                    fields: {
                        number: {
                            selector: '#card-number'
                        },
                        cvv: {
                            selector: '#cvv'
                        },
                        expirationDate: {
                            selector: '#expiration-date'
                        }
                    }
                }, function(hostedFieldsErr, hostedFieldsInstance) {
                    if (hostedFieldsErr) {
                        console.error('Hosted Fields Error:', hostedFieldsErr);
                        return;
                    }

                    form.addEventListener('submit', function(event) {
                        event.preventDefault();

                        hostedFieldsInstance.tokenize(function(tokenizeErr, payload) {
                            if (tokenizeErr) {
                                document.getElementById('card-errors').textContent =
                                    tokenizeErr.message;
                                return;
                            }

                            const nonceInput = document.createElement('input');
                            nonceInput.type = 'hidden';
                            nonceInput.name = 'payment_method_nonce';
                            nonceInput.value = payload.nonce;
                            form.appendChild(nonceInput);
                            form.submit();
                        });
                    });
                });

                // 2️⃣ PayPal Integration (Optional)
                braintree.paypalCheckout.create({
                    client: clientInstance
                }, function(paypalErr, paypalCheckoutInstance) {
                    if (paypalErr) return;

                    paypal.Buttons({
                        fundingSource: paypal.FUNDING.PAYPAL,
                        createOrder: function() {
                            return paypalCheckoutInstance.createPayment({
                                flow: 'checkout',
                                amount: totalAmount,
                                currency: 'USD'
                            });
                        },
                        onApprove: function(data, actions) {
                            return paypalCheckoutInstance.tokenizePayment(data).then(
                                function(payload) {
                                    const nonceInput = document.createElement(
                                        'input');
                                    nonceInput.type = 'hidden';
                                    nonceInput.name = 'payment_method_nonce';
                                    nonceInput.value = payload.nonce;
                                    form.appendChild(nonceInput);
                                    form.submit();
                                });
                        }
                    }).render('#paypal-button-container'); // Add this div manually
                });

                // 3️⃣ Apple Pay & Google Pay: Optional
                // You can add similar logic for `braintree.applePay.create()` and `braintree.googlePayment.create()` here
            });
        });
    </script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalAmount = parseFloat('{{ $total ?? 10.0 }}'); // Safer fallback

            braintree.dropin.create({
                authorization: "{{ $clientToken }}",
                container: '#dropin-container',

                // Enable PayPal
                paypal: {
                    flow: 'checkout',
                    amount: totalAmount,
                    currency: 'USD',
                    requestBillingAgreement: true, // Optional
                    shippingAddressEditable: true,
                    shippingAddressOverride: {
                        recipientName: '{{ auth()->user()->name }}',
                        line1: '{{ old('address') }}',
                        city: '{{ old('city') }}',
                        countryCode: 'US', // Or pull from your selected country
                        postalCode: '{{ old('zip') }}',
                        state: '{{ old('state') }}'
                    }
                },
                // Enable Google Pay
                googlePay: {
                    googlePayVersion: 2,
                    environment: 'TEST',
                    merchantId: '{{ env('BRAINTREE_MERCHANT_ID') }}', // Use 'dummy_merchant_id' in sandbox
                    transactionInfo: {
                        totalPriceStatus: 'FINAL',
                        totalPrice: totalAmount.toFixed(2),
                        currencyCode: 'USD'
                    },
                    allowedPaymentMethods: [{
                        type: 'CARD',
                        parameters: {
                            allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                            allowedCardNetworks: ['VISA', 'MASTERCARD']
                        },
                        tokenizationSpecification: {
                            type: 'PAYMENT_GATEWAY',
                            parameters: {
                                gateway: 'braintree',
                                gatewayMerchantId: '{{ env('BRAINTREE_MERCHANT_ID') }}'
                            }
                        }
                    }]
                },

                // Enable Cardholder name input
                card: {
                    cardholderName: {
                        required: true
                    }
                }

            }, function(createErr, instance) {
                if (createErr) {
                    console.error('Braintree Drop-in Error:', createErr);
                    return;
                }

                const form = document.getElementById('payment-form');
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    instance.requestPaymentMethod(function(err, payload) {
                        if (err) {
                            console.error('Payment method error:', err);
                            return;
                        }

                        // Append nonce to the form
                        const nonceInput = document.createElement('input');
                        nonceInput.type = 'hidden';
                        nonceInput.name = 'payment_method_nonce';
                        nonceInput.value = payload.nonce;
                        form.appendChild(nonceInput);

                        form.submit();
                    });
                });
            });
        });
    </script> --}}
@endsection
