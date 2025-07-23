@extends('layouts.admin_master')
@section('title','Social Media Links')
@section('page_title','Social Media Settings')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4>Update Social Media Links</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            <form action="{{ route('social.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'] as $platform)
                <div class="form-group">
                    <label for="{{ $platform }}">{{ ucfirst($platform) }} URL</label>
                    <input type="url" class="form-control @error($platform) is-invalid @enderror" name="{{ $platform }}"
                        value="{{ old($platform, $setting->$platform) }}">
                    @error($platform)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
