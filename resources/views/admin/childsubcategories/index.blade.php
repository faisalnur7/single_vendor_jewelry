@extends('layouts.admin_master')

@section('title', 'Child Sub Category list')
@section('page_title', 'Child Sub Category list')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Child Sub Category List</h3>
            <a href="{{ route('childsubcategory.create') }}" class="btn btn-primary btn-sm ml-auto">
                <i class="fas fa-plus"></i> Add Child Sub Category
            </a>
        </div>

        <div class="card-body px-0 pb-4 pt-0">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Category</th>
                            <th>SubCategory</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($childsubcategories as $childsubcategory)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($childsubcategory->image)
                                        <img src="{{ asset($childsubcategory->image) }}" alt="Image" height="50">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $childsubcategory->name }}</td>
                                <td>{{ $childsubcategory->slug }}</td>
                                <td>{{ $childsubcategory->category ? $childsubcategory->category->name : 'N/A' }}</td>
                                <td>{{ $childsubcategory->subcategory ? $childsubcategory->subcategory->name : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('childsubcategory.edit', $childsubcategory->id) }}" 
                                       class="btn btn-outline-dark btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('childsubcategory.destroy', $childsubcategory->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this child subcategory?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No Child SubCategories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
