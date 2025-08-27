@extends('layouts.admin_master')

@section('title', 'Shipping Policy List')
@section('page_title', 'Shipping Policy List')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Shipping Policy List</h3>
            <a href="{{ route('shipping_policy.create') }}" class="btn btn-primary btn-sm ml-auto">
                <i class="fas fa-plus"></i> Add Shipping Policy
            </a>
        </div>

        <div class="card-body px-0 pb-4 pt-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($policies as $policy)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $policy->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($policy->description, 50) }}</td>
                                <td>
                                    @if($policy->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('shipping_policy.edit', $policy->id) }}" class="btn btn-outline-dark btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('shipping_policy.delete', $policy->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this policy?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Shipping Policies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $policies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
