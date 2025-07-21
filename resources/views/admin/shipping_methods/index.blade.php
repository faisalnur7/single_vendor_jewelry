@extends('layouts.admin_master')
@section('title', 'Shipping Methods')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Shipping Method List</h3>
            <button id="addBtn" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Shipping
            </button>
        </div>

        <div class="card-body px-0 pb-4 pt-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="shippingTable">
                        @forelse ($shippingMethods as $shipping)
                            <tr data-id="{{ $shipping->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($shipping->logo)
                                        <img src="{{ asset($shipping->logo) }}" alt="logo" class="rounded" height="30">
                                    @endif
                                </td>
                                <td>{{ $shipping->name }}</td>
                                <td>${{ number_format($shipping->cost, 2) }}</td>
                                <td>
                                    <button class="btn btn-sm toggleStatus {{ $shipping->status ? 'btn-success' : 'btn-danger' }}">
                                        {{ $shipping->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-outline-dark btn-sm editBtn"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-danger btn-sm deleteBtn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No shipping methods found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="shippingForm" enctype="multipart/form-data" class="modal-content">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" id="shipping_id" name="id">

            <div class="modal-header">
                <h5 class="modal-title" id="shippingModalLabel">Add Shipping Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Cost</label>
                    <input type="number" step="0.01" name="cost" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Logo</label>
                    <input type="file" name="logo" accept="image/*" class="form-control">
                    <div id="previewLogo" class="mt-2"></div>
                </div>
                <div class="mb-3 d-none" id="statusField">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submitBtn">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Toastr & jQuery -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    const routes = {
        store: "{{ route('shipping-methods.store') }}",
        update: "{{ route('shipping-methods.update', ['shippingMethod' => 'SHIPPING_ID']) }}",
        toggleStatus: "{{ route('shipping-methods.toggle-status', ['shippingMethod' => 'SHIPPING_ID']) }}",
        edit: "{{ route('shipping-methods.edit', ['shippingMethod' => 'SHIPPING_ID']) }}",
        delete: "{{ route('shipping-methods.destroy', ['shippingMethod' => 'SHIPPING_ID']) }}"
    };
</script>

<script>
$(function () {
    let modal = new bootstrap.Modal(document.getElementById('shippingModal'));
    let form = $('#shippingForm');

    $('#addBtn').on('click', () => {
        form[0].reset();
        $('#shipping_id').val('');
        $('#shippingModalLabel').text('Add Shipping Method');
        $('#statusField').addClass('d-none');
        $('#previewLogo').html('');
        form.find('input[name="_method"]').val('POST');
        modal.show();
    });

    form.on('submit', function (e) {
        e.preventDefault();
        let id = $('#shipping_id').val();

        let url = id ? routes.update.replace('SHIPPING_ID', id) : routes.store;
        let method = 'POST';

        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success(res) {
                toastr.success(id ? 'Updated successfully' : 'Created successfully');
                location.reload();
            },
            error(err) {
                toastr.error('Error occurred');
            }
        });
    });


    // Edit
    $(document).on('click', '.editBtn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');

        let url = routes.edit.replace('SHIPPING_ID', id);

        $.get(url, function (res) {
            $('#shipping_id').val(res.id);
            $('#shippingModalLabel').text('Edit Shipping Method');
            form.find('input[name="name"]').val(res.name);
            form.find('textarea[name="description"]').val(res.description);
            form.find('input[name="cost"]').val(res.cost);
            form.find('select[name="status"]').val(res.status);
            $('#statusField').removeClass('d-none');
            $('#previewLogo').html(res.logo ? `<img src="/${res.logo}" height="40">` : '');
            
            modal.show();
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function () {
        if (!confirm('Are you sure?')) return;
        let id = $(this).closest('tr').data('id');

        let url = routes.delete.replace('SHIPPING_ID', id);

        $.ajax({
            url: url,
            type: 'POST',
            data: {_method: 'DELETE', _token: '{{ csrf_token() }}'},
            success() {
                toastr.success('Deleted successfully');
                location.reload();
            },
            error() {
                toastr.error('Failed to delete');
            }
        });
    });


    // Toggle status
    $(document).on('click', '.toggleStatus', function () {
        let btn = $(this);
        let id = btn.closest('tr').data('id');

        let url = routes.toggleStatus.replace('SHIPPING_ID', id);

        $.post(url, {_token: '{{ csrf_token() }}'}, function (res) {
            if (res.new_status) {
                btn.removeClass('btn-danger').addClass('btn-success').text('Active');
            } else {
                btn.removeClass('btn-success').addClass('btn-danger').text('Inactive');
            }
            toastr.success('Status updated');
        }).fail(() => {
            toastr.error('Failed to update status');
        });
    });

});
</script>
@endsection
