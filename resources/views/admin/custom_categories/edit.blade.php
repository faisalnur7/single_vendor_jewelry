@extends('layouts.admin_master')

@section('title', 'Edit Custom Category')
@section('page_title', 'Edit Custom Category')

@section('contents')

    <div class="container-fluid">
        <div class="card">
            <div
                class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
                <h3 class="card-title">Edit Custom Category</h3>
            </div>
            <div class="card-body">
                <!-- Form to edit custom category -->
                <form action="{{ route('custom-category.update', $customCategory->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf


                    <!-- Parent Category -->
                    <div class="form-group">
                        <label for="category_id">Parent Category</label>
                        <select name="category_id" id="category_id"
                            class="form-control select2 @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories->where('show_on_main_menu', 1) as $category)
                                <option value="{{ $category->id }}"
                                    {{ (old('category_id', $customCategory->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sub Category -->
                    <div class="form-group">
                        <label for="sub_category_id">Sub Category</label>
                        <select name="sub_category_id" id="sub_category_id"
                            class="form-control select2 @error('sub_category_id') is-invalid @enderror">
                            <option value="">-- Select Sub Category --</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}"
                                    {{ (old('sub_category_id', $customCategory->sub_category_id) == $subCategory->id) ? 'selected' : '' }}>
                                    {{ $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Child Sub Category -->
                    <div class="form-group">
                        <label for="child_sub_category_id">Child Sub Category</label>
                        <select name="child_sub_category_id" id="child_sub_category_id"
                            class="form-control select2 @error('child_sub_category_id') is-invalid @enderror">
                            <option value="">-- Select Child Sub Category --</option>
                            @foreach ($childSubCategories as $childSubCategory)
                                <option value="{{ $childSubCategory->id }}"
                                    {{ (old('child_sub_category_id', $customCategory->child_sub_category_id) == $childSubCategory->id) ? 'selected' : '' }}>
                                    {{ $childSubCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('child_sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Custom Category Name -->
                    <div class="form-group">
                        <label for="name">Custom Category Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control slugify @error('name') is-invalid @enderror"
                            value="{{ old('name', $customCategory->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug"
                            class="form-control slug_text @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $customCategory->slug) }}" required>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Type -->
                    <div class="form-group">
                        <label for="type">Category Type</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                            required>
                            <option value="">-- Select Type --</option>
                            @foreach (\App\Models\CustomCategory::CUSTOM_CATEGORY_TYPE as $key => $label)
                                <option value="{{ $key }}"
                                    {{ (old('type', $customCategory->type) == $key) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="number" name="order" id="order" class="form-control"
                            value="{{ old('order', $customCategory->order) }}" min="0" />
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="mb-2">
                            @if ($customCategory->image)
                                <img src="{{ asset($customCategory->image) }}"
                                    alt="Custom Category Image" class="img-thumbnail" width="120">
                            @endif
                        </div>
                        <input type="file" name="image"
                            class="form-control-file @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update Custom Category</button>
                        <a href="{{ route('custom-category.list') }}" class="btn btn-neutral">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
