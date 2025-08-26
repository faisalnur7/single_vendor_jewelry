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
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
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

                <!-- Checkboxes -->
                <div class="pb-4 flex gap-4">
                    <div class="form-check justify-start items-start flex">
                        <input type="checkbox" name="is_trending" id="is_trending" value="1" 
                            class="form-check-input" 
                            {{ old('is_trending', $category->is_trending) ? 'checked' : '' }}>
                        <label class="form-check-label text-md " for="is_trending">Trending Category</label>
                    </div>

                    <div class="form-check justify-start items-start flex">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                            class="form-check-input" 
                            {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label text-md " for="is_featured">Featured Category</label>
                    </div>

                    <div class="form-check justify-start items-start flex">
                        <input type="checkbox" name="show_on_main_menu" id="show_on_main_menu" value="1" 
                            class="form-check-input" 
                            {{ old('show_on_main_menu', $category->show_on_main_menu) ? 'checked' : '' }}>
                        <label class="form-check-label text-md " for="show_on_main_menu">Show on Main Menu</label>
                    </div>
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