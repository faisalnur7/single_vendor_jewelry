@extends('layouts.admin_master')
@section('title', 'Home Page Settings')
@section('page_title', 'Home Page Settings')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4>Update Home Page Sections</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            <form action="{{ route('homepage.update') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="why_choose_us">Why Choose Us</label>
                    <textarea class="form-control summernote @error('why_choose_us') is-invalid @enderror" name="why_choose_us" rows="4">{{ old('why_choose_us', $setting->why_choose_us) }}</textarea>
                    @error('why_choose_us')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="about">About</label>
                    <textarea class="form-control summernote @error('about') is-invalid @enderror" name="about" rows="4">{{ old('about', $setting->about) }}</textarea>
                    @error('about')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="down_paragraph">Bottom Paragraph</label>
                    <textarea class="form-control summernote @error('down_paragraph') is-invalid @enderror" name="down_paragraph" rows="4">{{ old('down_paragraph', $setting->down_paragraph) }}</textarea>
                    @error('down_paragraph')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    $(function(){
        $('.summernote').summernote({
            height: 500,
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '32', '36', '48', '64', '72', '96'],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Playfair Display', 'Serif'],
            fontNamesIgnoreCheck: ['Playfair Display'],
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onPaste: function(e) {
                    const bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });


    })
</script>
@endsection