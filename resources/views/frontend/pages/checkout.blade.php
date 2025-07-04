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
                            <p class="text-gray-800">@if(!empty(auth()->user())){{ auth()->user()->email }}@endif</p>
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

                            <!-- Country -->

                            <div class="mb-4">
                                <label for="country" class="block text-sm font-medium mb-1">Country/Region</label>
                                <select id="country" name="country" required autocomplete="shipping country"
                                    class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">---</option>
                                    <option value="US">United States</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="GR">Greece</option>
                                    <option value="AU">Australia</option>
                                    <option value="CA">Canada</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="AT">Austria</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BR">Brazil</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="CL">Chile</option>
                                    <option value="CO">Colombia</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czechia</option>
                                    <option value="DK">Denmark</option>
                                    <option value="EE">Estonia</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="DE">Germany</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MT">Malta</option>
                                    <option value="MX">Mexico</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NO">Norway</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RO">Romania</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="ES">Spain</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TR">Türkiye</option>
                                    <option value="AE">United Arab Emirates</option>
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
                                    <input type="text" name="city"
                                        class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">State</label>
                                    <select name="state"
                                        class="w-full border-gray-300 rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="AL" selected>Alabama</option>
                                        <option value="CA">California</option>
                                        <option value="NY">New York</option>
                                        <!-- Add more states -->
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

                            <!-- Checkbox -->
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="checkbox" id="sms_opt_in" name="sms_opt_in"
                                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                <label for="sms_opt_in" class="text-sm text-gray-700">Text me with news and offers</label>
                            </div>
                        </div>

                        <!-- SHIPPING METHOD -->
                        <div class="bg-gray-100 p-4 rounded border text-sm text-gray-700">
                            <strong>Shipping method</strong>
                            <p class="text-gray-500 mt-2">Enter your shipping address to view available shipping methods.
                            </p>
                        </div>


                        <button class="mt-6 w-full bg-[#105989] text-white py-3 rounded hover:bg-[#105989] transition">
                            Pay now
                        </button>
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
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
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
