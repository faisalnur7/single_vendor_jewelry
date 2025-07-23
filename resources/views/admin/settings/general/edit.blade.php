@extends('layouts.admin_master')

@section('title','General Settings')
@section('page_title','General Settings')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title">Edit General Settings</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            <form action="{{ route('admin.general-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $settings->site_name ?? '') }}">
                    @error('site_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="site_title">Site Title</label>
                    <input type="text" name="site_title" id="site_title" class="form-control @error('site_title') is-invalid @enderror" value="{{ old('site_title', $settings->site_title ?? '') }}">
                    @error('site_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <input type="text" name="timezone" id="timezone" class="form-control @error('timezone') is-invalid @enderror" value="{{ old('timezone', $settings->timezone ?? 'Asia/Dhaka') }}">
                    @error('timezone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Site Logo Upload -->
                <div class="form-group">
                    <label for="site_logo">Site Logo</label>
                    <input type="file" name="site_logo" class="form-control-file @error('site_logo') is-invalid @enderror">
                    @error('site_logo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if(!empty($settings->site_logo))
                        <div class="mt-4">
                            <img src="{{ asset($settings->site_logo) }}" class="h-24" alt="Logo" height="80">
                        </div>
                    @endif
                </div>

                <!-- Favicon Upload -->
                <div class="form-group">
                    <label for="site_favicon">Site Favicon</label>
                    <input type="file" name="site_favicon" class="form-control-file @error('site_favicon') is-invalid @enderror">
                    @error('site_favicon')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if(!empty($settings->site_favicon))
                        <div class="mt-4">
                            <img src="{{ asset($settings->site_favicon) }}" class="h-20" alt="Favicon" height="40">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update Settings</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-neutral">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
