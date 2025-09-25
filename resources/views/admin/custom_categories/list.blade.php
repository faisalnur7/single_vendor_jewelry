@extends('layouts.admin_master')

@section('title', 'Custom Category List')
@section('page_title', 'Custom Category List')

@section('contents')
    <div class="container-fluid">
        <div class="card">
            <div
                class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Custom Category List</h3>
                <a href="{{ route('custom-category.create') }}" class="btn btn-primary btn-sm ml-auto">
                    <i class="fas fa-plus"></i> Add Custom Category
                </a>
            </div>

            <div class="card-body px-0 pb-4 pt-0">
                @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent Category</th>
                                <th>Sub Category</th>
                                <th>Child Sub Category</th>
                                <th>Image</th>
                                <th>Order</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customCategories as $customCategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ \App\Models\CustomCategory::CUSTOM_CATEGORY_TYPE[$customCategory->type] ?? '-' }}
                                    </td>
                                    <td>{{ $customCategory->name }}</td>
                                    <td>{{ $customCategory->slug }}</td>
                                    <td>{{ $customCategory->category?->name ?? '-' }}</td>
                                    <td>{{ $customCategory->subCategory?->name ?? '-' }}</td>
                                    <td>{{ $customCategory->childSubCategory?->name ?? '-' }}</td>
                                    <td>
                                        @if (!empty($customCategory->image))
                                            <img src="{{ asset($customCategory->image) }}" class="h-24" />
                                        @endif
                                    </td>
                                    <td>{{ $customCategory->order }}</td>
                                    <td>
                                        <a href="{{ route('custom-category.edit', $customCategory->id) }}"
                                            class="btn btn-outline-dark btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('custom-category.delete', $customCategory->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this custom category?')"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No custom categories found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
