@extends('frontend.layouts.main')
@section('title', 'Privacy Policy')

@section('styles')
    <style>
        .prose p {
            margin-bottom: 0.5rem;
            line-height: 1.2 !important;
        }

        .prose span {
            display: inline;
        }
    </style>
@endsection
@section('contents')

<section class="mt-24 pt-0 pb-12 px-6">
    <div class="mx-auto max-w-6xl">
        <h2 class="text-2xl text-center font-semibold mb-6">Privacy Policy</h2>

        <div class="space-y-4">
            @foreach($privacy_policies->where('status', 1) as $privacy_policy)
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $privacy_policy->title }}</h3>
                    <div class="text-gray-700 prose">
                        {!! $privacy_policy->description !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
