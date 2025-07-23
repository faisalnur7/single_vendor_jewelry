@extends('layouts.admin_master')

@section('title','Add Subscription Package')
@section('page_title','Add Subscription Package')

@section('contents')

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title">Add New Subscription Package</h3>
        </div>
        <div class="card-body">
            <!-- Form to create subscription package -->
            <form action="{{ route('subscription_package.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Package Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Subtitle Field -->
                <div class="form-group">
                    <label for="sub_title">Package Subtitle</label>
                    <input type="text" name="sub_title" id="sub_title" class="form-control @error('sub_title') is-invalid @enderror" value="{{ old('sub_title') }}">
                    @error('sub_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Duration (Days)</label>
                    <input type="number" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration') }}" required>
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount">Discount</label>
                    <input type="number" step="0.01" name="discount" id="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}" required>
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Features Section -->
                <div class="form-group">
                    <label>Assign Features</label>
                    <div class="row">
                        @foreach($features as $feature)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="features[]"
                                           value="{{ $feature->id }}"
                                           class="form-check-input"
                                           id="feature_{{ $feature->id }}"
                                           {{ (is_array(old('features')) && in_array($feature->id, old('features'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_{{ $feature->id }}">
                                        {{ $feature->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('features')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- End Features Section -->

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Save Package</button>
                    <a href="{{ route('subscription_package.list') }}" class="btn btn-neutral">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
