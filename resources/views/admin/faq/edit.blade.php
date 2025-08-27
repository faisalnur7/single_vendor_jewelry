@extends('layouts.admin_master')

@section('title','Edit FAQ')
@section('page_title','Edit FAQ')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Edit FAQ</h3>
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

            <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                @csrf
                {{-- If you change to PUT/PATCH in route, also add: @method('PUT') --}}

                <div class="form-group mb-3">
                    <label>Question <span class="text-danger">*</span></label>
                    <input type="text" name="question" class="form-control"
                        value="{{ old('question', $faq->question) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Answer <span class="text-danger">*</span></label>
                    <textarea name="answer" class="form-control" rows="4" required>{{ old('answer', $faq->answer) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', $faq->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $faq->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Update
                </button>
                <a href="{{ route('faq.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
