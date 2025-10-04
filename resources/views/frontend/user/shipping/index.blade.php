@extends('frontend.user.profile')

@section('user_contents')
<div class="mb-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold">My Shipping Addresses</h2>
    <a href="{{ route('user_shipping_create') }}" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
        Add New
    </a>
</div>

<div class="bg-white shadow rounded-lg p-4">
    @if($addresses->count())
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Address</th>
                        <th class="px-4 py-2 border">City</th>
                        <th class="px-4 py-2 border">State</th>
                        <th class="px-4 py-2 border">Country</th>
                        <th class="px-4 py-2 border">Default</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($addresses as $key => $address)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $key + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $address->name }}</td>
                            <td class="px-4 py-2 border">{{ $address->address }}</td>
                            <td class="px-4 py-2 border">{{ $address->city->name }}</td>
                            <td class="px-4 py-2 border">{{ $address->state->name }}</td>
                            <td class="px-4 py-2 border">{{ $address->country->name }}</td>
                            <td class="px-4 py-2 border">
                                @if($address->is_default)
                                    <span class="text-green-600 font-semibold">Yes</span>
                                @else
                                    No
                                @endif
                            </td>
                            <td class="px-4 py-2 border space-x-2 flex items-center">
                                <!-- Edit button -->
                                <a href="{{ route('user_shipping_edit', $address->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete button -->
                                <form action="{{ route('user_shipping_delete', $address->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No shipping addresses found.</p>
    @endif
</div>
@endsection
