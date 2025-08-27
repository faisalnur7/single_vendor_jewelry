@extends('frontend.user.profile')

@section('user_contents')
    <h2 class="text-lg font-semibold mb-4">Add New Shipping Address</h2>

    <form action="{{ route('user_shipping_store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-gray-600">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-600">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2"
                required>
        </div>

        <div>
            <label class="block text-gray-600">Address</label>
            <textarea name="address" class="w-full border rounded px-3 py-2" required>{{ old('address') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-600">Country</label>
            <select name="country" id="country" class="w-full border rounded px-3 py-2 select2" required>
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-600">State</label>
            <select name="state" id="state" class="w-full border rounded px-3 py-2 select2">
                <option value="">Select State</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-600">City</label>
            <select name="city" id="city" class="w-full border rounded px-3 py-2 select2">
                <option value="">Select City</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-600">ZIP Code</label>
            <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
            <label class="text-gray-600">Set as default address</label>
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Address</button>
        </div>
    </form>
@endsection
<!-- jQuery AJAX for dependent dropdowns -->
@section('scripts')
    <script>
        $(function() {
            $('.select2').select2();

            $('#country').on('change', function() {
                const countryId = $(this).val();
                $('#state').html('<option value="">Loading...</option>');
                $('#city').html('<option value="">Select City</option>');

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
                            $('#state').html(options);
                        }
                    });
                }
            });

            $('#state').on('change', function() {
                const stateId = $(this).val();
                $('#city').html('<option value="">Loading...</option>');

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
                            $('#city').html(options);
                        }
                    });
                }
            });

        })
    </script>
@endsection
