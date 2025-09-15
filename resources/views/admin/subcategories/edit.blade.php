@extends('layouts.admin_master')

@section('title','Sub Category Edit')
@section('page_title','Sub Category Edit')

@section('contents')

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title">Edit SubCategory</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('subcategory.update', $subcategory->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="name">SubCategory Name</label>
                    <input type="text" name="name" id="name" class="form-control slugify @error('name') is-invalid @enderror" value="{{ old('name', $subcategory->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control slug_text @error('slug') is-invalid @enderror" value="{{ old('slug', $subcategory->slug) }}" required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="order">Order</label>
                    <input type="number" name="order" id="order" class="form-control" value="{{ $subcategory->order }}" min="0" />

                </div>


                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" 
                        class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if($subcategory->image)
                        <div class="mt-2">
                            <img src="{{ asset($subcategory->image) }}" alt="Image" height="80">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update SubCategory</button>
                    <a href="{{ route('subcategory.list') }}" class="btn btn-neutral">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection