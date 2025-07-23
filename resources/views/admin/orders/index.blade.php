@extends('layouts.admin_master')

@section('title', 'Order List')
@section('page_title', 'Order List')

@section('contents')
    <div class="container-fluid">

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter Form --}}
        <div class="card border-0 shadow-sm rounded mb-4">
            <div
                class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Filter Orders</h4>
            </div>
            <div class="card-body">
                @include('admin.orders._filter_forms')
            </div>
        </div>

        {{-- Order Table --}}
        <div class="card border-0 shadow-sm rounded">
            <div
                class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center rounded-top">
                <h4 class="mb-0">All Orders</h4>
            </div>

            <div class="card-body px-0 pb-4 pt-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Subtotal</th>
                                <th>Shipping Charge</th>
                                <th>Shipping Method</th>
                                <th>Shipping Url</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $order->order_tracking_number }}</td>
                                    <td>{{ $order->user->name ?? '-' }}</td>
                                    <td>{{ $order->billing_address ?? '-' }}</td>
                                    <td>${{ number_format($order->subtotal, 2) }}</td>
                                    <td>${{ number_format($order->shipping_charge, 2) }}</td>
                                    <td class="w-[200px]"><a class="text-wrap" target="_blank" href="{{ $order->shipping_url ?? '' }}">{{ $order->shipping_url ?? '' }}</a></td>
                                    <td>{{ $order->shipping_method->name ?? 'Not added' }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $order->payment_option_name)) }}</td>
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);"
                                            class="btn btn-outline-info btn-sm rounded view-order-btn"
                                            data-id="{{ $order->id }}" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="#" class="btn btn-outline-secondary btn-sm rounded print-invoice-btn"
                                            onclick="openInvoicePopup(event, '{{ route('order.print_invoice', $order->id) }}')"
                                            title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Order Details Modal -->
                    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title" id="orderDetailsLabel">Order Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body" id="orderDetailsContent">
                                    <div class="text-center">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-neutral btn-close"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="updateOrderStatusBtn" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Status
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Modal -->
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function() {
            // View Order Details
            $(document).on('click', '.view-order-btn', function() {
                let orderId = $(this).data('id');
                $('#orderDetailsModal').modal('show');
                $('#orderDetailsModal').css('visibility','visible');
                $('#orderDetailsModal').css('z-index','99999');
                $('.modal-backdrop').css('z-index','1040');

                $('#orderDetailsContent').html(`
                    <div class="text-center p-5">
                        <div class="spinner-border text-dark" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('order.show') }}",
                    method: 'GET',
                    data: {
                        order_id: orderId
                    },
                    success: function(response) {
                        $('#orderDetailsContent').html(response);
                    },
                    error: function() {
                        $('#orderDetailsContent').html(
                            '<div class="alert alert-danger">Failed to load order details.</div>'
                        );
                    }
                });
            });

            // Update Order Status
            $(document).on('click', '#updateOrderStatusBtn', function() {
                let formData = $('#orderStatusForm').serialize();
                $.ajax({
                    url: "{{ route('order.update.status') }}",
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        $('#orderDetailsModal').modal('hide');
                        $('#orderDetailsModal').css('visibility','hidden');
                        toastr.success('Order status updated.');
                        location.reload();
                    },
                    error: function() {
                        toastr.error('Failed to update order status.')
                    }
                });
            });
        });

        function openInvoicePopup(e, url) {
            e.preventDefault(); // Prevent normal navigation

            const width = 1024;
            const height = 900;
            const left = 0;
            const top = 0;
            window.open(
                url,
                '_blank',
                `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`
            );
        }
    </script>
@endsection
