@extends('layouts.admin_master')

@section('title', 'Product Details')
@section('page_title', 'Product Details')

@section('contents')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card shadow-sm p-3">
                    <div class="row">
                        <div class="col-md-5">

                            {{-- Image Slider Start --}}
                            @php
                                $galleryImages = json_decode($product->gallery_images, true);
                            @endphp

                            <div id="productImageSlider" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">

                                    @if (!empty($galleryImages))
                                        @foreach ($galleryImages as $index => $imagePath)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($imagePath) }}" class="d-block w-100 rounded"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            @if ($product->image && file_exists(public_path($product->image)))
                                                <img src="{{ asset($product->image) }}" class="d-block w-100 rounded"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <img src="https://via.placeholder.com/300x300?text=No+Image"
                                                    class="d-block w-100 rounded" alt="No Image">
                                            @endif
                                        </div>
                                    @endif

                                </div>

                                @if (!empty($galleryImages) && count($galleryImages) > 1)
                                    <a class="carousel-control-prev" href="#productImageSlider" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#productImageSlider" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                @endif
                            </div>
                            {{-- Image Slider End --}}

                        </div>

                        <div class="col-md-7">
                            <div class="card-body">
                                <div class="row">
                                    <h2 class="card-title mb-3 text-bold text-xl">{{ $product->name }}</h2>
                                </div>

                                @if($product->has_variants)
                                    <div class="row">
                                        <h4 class="text-primary mb-3">
                                            ${{ number_format($product->min_price, 2) }}-${{ number_format($product->max_price, 2) }}
                                        </h4>
                                    </div>
                                @else
                                    <div class="row">
                                        <h4 class="text-primary mb-3">
                                            ${{ number_format($product->price, 2) }}
                                        </h4>
                                    </div>
                                @endif

                                <p class="mb-1"><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Sub Category:</strong> {{ $product->subCategory->name ?? 'N/A' }}
                                </p>
                                <p class="mb-1"><strong>Child Category:</strong>
                                    {{ $product->childSubCategory->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Stock:</strong> {{ $product->stock }}</p>

                                <p class="mb-3">
                                    <strong>Status:</strong>
                                    @if ($product->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </p>

                                <hr>

                                <p class="mt-3">
                                    <strong>Description:</strong><br>
                                    {!! nl2br(e($product->description ?? 'No description provided.')) !!}
                                </p>

                                <div class="mt-4">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-dark">
                                        <i class="fas fa-edit"></i> Edit Product
                                    </a>
                                    <a href="{{ route('product.list') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                @if ($product->has_variants)

                    {{-- Product Table --}}
                    <div class="card border-0 shadow-sm rounded">
                        <div
                            class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center rounded-top">
                            <h4 class="mb-0">Product Variants</h4>
                            {{-- <div class="ml-auto">
                        <a href="{{ route('product.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div> --}}
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
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($product->variants as $product)
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
                                                <td>${{ number_format($product->price, 2) }}</td>
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

                                                    <form action="{{ route('product.delete', $product->id) }}"
                                                        method="POST" class="d-inline"
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
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
