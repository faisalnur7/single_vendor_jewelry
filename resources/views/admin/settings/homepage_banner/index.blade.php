@extends('layouts.admin_master')

@section('title', 'Home Page Settings')
@section('page_title', 'Home Page Settings')

@section('contents')
    <div class="container-fluid">

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Homepage Banner Table --}}
        <div class="card border-0 shadow-sm rounded">
            <div
                class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center rounded-top">
                <h4 class="mb-0">Homepage Banners</h4>
                <div class="ml-auto">
                    <a href="{{ route('homepage_banner.create') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus"></i> Add Banner
                    </a>
                </div>
            </div>

            <div class="card-body px-0 pb-4 pt-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Child Sub Category</th>
                                <th>Banner</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($banners as $banner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $banner->category?->name ?? '-' }}</td>
                                    <td>{{ $banner->subCategory?->name ?? '-' }}</td>
                                    <td>{{ $banner->childSubCategory?->name ?? '-' }}</td>
                                    <td>
                                        @if ($banner->banner)
                                            <img src="{{ asset($banner->banner) }}" alt="Banner"
                                                class="img-thumbnail" style="height: 150px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($banner->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('homepage_banner.edit', $banner->id) }}"
                                            class="btn btn-outline-warning btn-sm rounded" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('homepage_banner.destroy', $banner->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded"
                                                title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No banners found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (if using paginate) --}}
                <div class="pagination-container flex justify-center mt-3">
                    <div class="flex items-center space-x-1 [&_svg]:w-4 [&_svg]:h-4">
                        {{ $banners->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
