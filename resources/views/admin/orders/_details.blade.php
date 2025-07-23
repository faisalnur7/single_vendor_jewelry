<div id="printableArea">
    <div class="p-3">
        <form id="orderStatusForm">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="form-group">
                <label><strong>Status:</strong></label>
                <select name="status" class="form-control">
                    @foreach (\App\Models\Order::ORDER_STATUS as $key => $label)
                        <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label><strong>Shipping URL:</strong></label>
                <input type="text" name="shipping_url" id="shipping_url" class="form-control"
                    value="{{ $order->shipping_url }}">
            </div>
        </form>
        <h5 class="mb-3 text-lg py-1 font-bold">Order Summary</h5>
        <div class="flex justify-between">
            <div>
                <p><strong>Tracking Number:</strong> {{ $order->order_tracking_number }}</p>
                <p><strong>Shipping Method:</strong> {{ $order->shipping_method->name }}</p>
                <p><strong>Customer:</strong> {{ $order->user->name ?? '-' }}</p>
                <p><strong>Ordered At:</strong> {{ $order->created_at->format('d M, Y h:i A') }}</p>
            </div>
            <div class="max-w-[400px]">
                <div class="flex">
                    <div><strong>Billing Address:</strong></div>
                    <div class="">{{ $order->billing_address }}</div>
                </div>
                <div class="flex">
                    <div><strong>Shipping Address:</strong></div>
                    <div class="">{{ $order->shipping_address }}</div>
                </div>
            </div>
        </div>


        <hr class="py-2">
        <h3 class="text-lg font-bold">Order Items</h3>
        <table class="table table-bordered">
            <thead>
                <tr class="text-black">
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    @php
                        $total = number_format($item->price * $item->quantity, 2);
                    @endphp
                    <tr>
                        <td>{{ $item->product->name }} - {{ $item->product->color ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>৳{{ number_format($item->price, 2) }}</td>
                        <td>৳{{ $total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right mt-3">
            <p><strong>Subtotal:</strong> ৳{{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Shipping:</strong> ৳{{ $order->shipping_charge }}</p>
            <p><strong>Total:</strong> ৳{{ number_format($order->total, 2) }}</p>
        </div>
    </div>
</div>
