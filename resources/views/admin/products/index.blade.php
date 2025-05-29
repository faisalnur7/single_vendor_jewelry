@extends('layouts.admin_master')

@section('title', 'Product List')
@section('page_title', 'Product List')

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
                <h4 class="mb-0">Filter Products</h4>
            </div>
            <div class="card-body">
                @include('admin.products._filter_form')
            </div>
        </div>

        {{-- Product Table --}}
        <div class="card border-0 shadow-sm rounded">
            <div
                class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center rounded-top">
                <h4 class="mb-0">All Products</h4>
                <div class="ml-auto">
                    <a href="{{ route('product.create') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>
            </div>


            <div class="card-body px-0 pb-4 pt-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th width="300">Product Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Child Sub Category</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Price(Max)</th>
                                <th>Price(Min)</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($product->image && file_exists(public_path($product->image)))
                                            <img src="{{ asset($product->image) }}" class="rounded"
                                                alt="{{ $product->name }}" width="60" height="60">
                                        @else
                                            <span class="badge badge-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->subCategory->name ?? 'N/A' }}</td>
                                    <td>{{ $product->childSubCategory->name ?? 'N/A' }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>@if($product->parent_id != 0)${{ number_format($product->price, 2) }} @else - @endif</td>
                                    <td>@if($product->parent_id == 0)${{ number_format($product->max_price, 2) }} @else - @endif</td>
                                    <td>@if($product->parent_id == 0)${{ number_format($product->min_price, 2) }} @else - @endif</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if ($product->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="btn btn-outline-info btn-sm rounded" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('product.edit', $product->id) }}"
                                            class="btn btn-outline-dark btn-sm rounded" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-container flex justify-center mt-0">
                    <div class="flex items-center space-x-1 [&_svg]:w-4 [&_svg]:h-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
