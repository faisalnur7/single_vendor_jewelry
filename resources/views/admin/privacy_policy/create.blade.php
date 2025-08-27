@extends('layouts.admin_master')

@section('title','Add Privacy Policy')
@section('page_title','Add Privacy Policy')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Add New Privacy Policy</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('privacy_policy.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control summernote" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.summernote').summernote({
                height: 100
            });
        })
    </script>
@endsection