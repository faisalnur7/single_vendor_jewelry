@extends('layouts.admin_master')

@section('title', 'Homepage Banners')
@section('page_title', 'Homepage Banners')

@section('contents')
    <div class="container-fluid">
        <div class="card">
            <div
                class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
                <h3 class="card-title">Add Banner</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('homepage_banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Category -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id"
                            class="form-control select2 @error('category_id') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $banner->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
                            <option value="">Select Sub Category </option>
                            @foreach ($subCategories as $sub)
                                <option value="{{ $sub->id }}"
                                    {{ old('sub_category_id', $banner->sub_category_id ?? '') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
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
                            <option value="">Select Child Sub Category </option>
                            @foreach ($childSubCategories as $child)
                                <option value="{{ $child->id }}"
                                    {{ old('child_sub_category_id', $banner->child_sub_category_id ?? '') == $child->id ? 'selected' : '' }}>
                                    {{ $child->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('child_sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Banner Image -->
                    <div class="form-group">
                        <label for="banner">Banner Image</label>
                        <input type="file" name="banner"
                            class="form-control-file @error('banner') is-invalid @enderror">
                        @error('banner')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        @if (!empty($banner->banner))
                            <div class="mt-4">
                                <img src="{{ asset($banner->banner) }}" class="h-24" alt="Banner" height="180">
                            </div>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', $banner->status ?? 1) == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $banner->status ?? 1) == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add Banner</button>
                        <a href="{{ route('homepage_banner.index') }}" class="btn btn-neutral">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            // When Category changes → Load Subcategories
            $('#category_id').on('change', function() {
                let categoryId = $(this).val();
                $('#sub_category_id').html('<option value="">Select Sub Category</option>');
                $('#child_sub_category_id').html('<option value="">Select Child Sub Category</option>');

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId),
                        type: "GET",
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, sub) {
                                    $('#sub_category_id').append('<option value="' + sub
                                        .id + '">' + sub.name + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            // When Sub Category changes → Load Child Subcategories
            $('#sub_category_id').on('change', function() {
                let subCategoryId = $(this).val();
                $('#child_sub_category_id').html('<option value="">Select Child Sub Category</option>');

                if (subCategoryId) {
                    $.ajax({
                        url: "{{ route('get.childsubcategories', ':id') }}".replace(':id', subCategoryId),
                        type: "GET",
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, child) {
                                    $('#child_sub_category_id').append(
                                        '<option value="' + child.id + '">' + child
                                        .name + '</option>');
                                });
                            }
                        }
                    });
                }
            });

        });
    </script>
@endsection
