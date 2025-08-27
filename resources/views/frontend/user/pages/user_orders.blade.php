@extends('frontend.user.profile')

@section('user_contents')
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('homepage') }}" class="hover:underline text-gray-600">Home</a>
        <span class="mx-2">/</span>
        <span class="text-gray-500">My Orders</span>
    </div>

    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">My Orders</h2>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Order ID</th>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Total</th>
                        <th class="px-4 py-2 border">Payment</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse($orders as $key => $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $key + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $order->order_tracking_number }}</td>
                            <td class="px-4 py-2 border">{{ $order->created_at->format('d M, Y') }}</td>
                            <td class="px-4 py-2 border">${{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst(str_replace('_', ' ', $order->payment_option_name)) }}
                            </td>
                            <td class="px-4 py-2 border">
                                <span
                                    class="px-2 py-1 rounded-full text-xs
                                    @if ($order->status == 'pending') bg-yellow-100 text-yellow-600
                                    @elseif($order->status == 'completed') bg-green-100 text-green-600
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('user_order_show', $order->id) }}"
                                    class="text-gray-600 hover:underline text-xs">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
