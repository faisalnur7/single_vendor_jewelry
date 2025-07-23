@extends('layouts.admin_master')

@section('title','Category list')
@section('page_title','Category list')


@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title">Edit Category</h3>
        </div>
        <div class="card-body">
            <!-- Form to edit category -->
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control slugify @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control slug_text @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}" required>
                    @error('slug')
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

                    @if($category->image)
                        <div class="mt-2">
                            <img src="{{ asset($category->image) }}" alt="Image" height="80">
                        </div>
                    @endif
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update Category</button>
                    <a href="{{ route('category.list') }}" class="btn btn-neutral">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection