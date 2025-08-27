@extends('frontend.user.profile')

@section('user_contents')
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('homepage') }}" class="hover:underline text-gray-600">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('user_order') }}" class="hover:underline text-gray-600">My Orders</a>
        <span class="mx-2">/</span>
        <span class="text-gray-500">Order #{{ $order->order_tracking_number }}</span>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Order Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <h3 class="font-semibold text-gray-600">Customer Info</h3>
                <p>Name: {{ $order->user->name }}</p>
                <p>Email: {{ $order->user->email }}</p>
                <p>Phone: {{ $order->phone }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-600">Order Info</h3>
                <p>Order Number: #{{ $order->order_tracking_number }}</p>
                <p>Order Date: {{ $order->created_at->format('d M, Y') }}</p>
                <p>Payment Method: {{ ucfirst(str_replace('_',' ', $order->payment_option_name)) }}</p>
                <p>Status:
                    <span
                        class="px-2 py-1 rounded-full text-xs
                        @if ($order->status == 'pending') bg-yellow-100 text-yellow-600
                        @elseif($order->status == 'completed') bg-green-100 text-green-600
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-600
                        @else bg-gray-100 text-gray-600 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        <h3 class="text-md font-semibold text-gray-700 mb-2">Order Items</h3>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Product</th>
                        <th class="px-4 py-2 border">Quantity</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($order->items as $key => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $key + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $item->product->name }} | <strong>{{ $item->product->color }}</strong></td>
                            <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 border">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-2 border">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">
            <p class="text-gray-700 font-semibold text-lg">Total: ${{ number_format($order->total, 2) }}</p>
        </div>
    </div>
@endsection
