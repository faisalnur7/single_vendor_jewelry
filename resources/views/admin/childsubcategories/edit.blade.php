@extends('layouts.admin_master')

@section('title', 'Edit Child SubCategory')
@section('page_title', 'Edit Child SubCategory')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title">Edit Child SubCategory</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('childsubcategory.update', $childsubcategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="name">Child SubCategory Name</label>
                    <input type="text" name="name" id="name" 
                        class="form-control slugify @error('name') is-invalid @enderror" 
                        value="{{ old('name', $childsubcategory->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" 
                        class="form-control slug_text @error('slug') is-invalid @enderror" 
                        value="{{ old('slug', $childsubcategory->slug) }}" required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" 
                        class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $childsubcategory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subcategory_id">SubCategory</label>
                    <select name="subcategory_id" id="subcategory_id" 
                        class="form-control @error('subcategory_id') is-invalid @enderror">
                        <option value="">Select SubCategory</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" 
                                {{ old('subcategory_id', $childsubcategory->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" 
                        class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if($childsubcategory->image)
                        <div class="mt-2">
                            <img src="{{ asset($childsubcategory->image) }}" alt="Image" height="80">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update Child SubCategory</button>
                    <a href="{{ route('childsubcategory.list') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
