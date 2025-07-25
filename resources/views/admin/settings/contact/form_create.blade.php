@extends('layouts.admin_master')

@section('title','Contact & Company Info')
@section('page_title','Contact & Company Info')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title">Contact & Company Info</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            <form action="{{ route('contact-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Company Email</label>
                    <input name="email" class="form-control" value="{{ old('email', $setting->email) }}">
                </div>

                <div class="form-group">
                    <label>Info Email</label>
                    <input name="info_email" class="form-control" value="{{ old('info_email', $setting->info_email) }}">
                </div>

                <div class="form-group">
                    <label>Customer Support Email</label>
                    <input name="customer_support_email" class="form-control" value="{{ old('customer_support_email', $setting->customer_support_email) }}">
                </div>
                
                <div class="form-group">
                    <label>WhatsApp</label>
                    <input name="whatsapp" class="form-control" value="{{ old('whatsapp', $setting->whatsapp) }}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input name="phone" class="form-control" value="{{ old('phone', $setting->phone) }}">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input name="address" class="form-control" value="{{ old('address', $setting->address) }}">
                </div>

                <div class="form-group">
                    <label>Google Map Embed</label>
                    <textarea name="google_map_embed" class="form-control" rows="3">{{ old('google_map_embed', $setting->google_map_embed) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Company Name</label>
                    <input name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name) }}">
                </div>

                <div class="form-group">
                    <label>Company Description</label>
                    <textarea name="company_description" class="form-control" rows="3">{{ old('company_description', $setting->company_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Company Logo</label>
                    <input type="file" name="company_logo" class="form-control-file">
                    @if($setting->company_logo)
                        <img src="{{ asset($setting->company_logo) }}" class="mt-4 h-24" height="80" class="mt-2">
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
