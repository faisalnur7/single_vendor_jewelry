@extends('frontend.layouts.main')
@section('title', 'Stainless Steel Jewelry')

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

    <section class="mt-6 md:mt-24 pt-0 pb-12 px-6">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-2xl text-center font-semibold mb-6">Return Policy</h2>

            <div class="space-y-4">
                @foreach ($return_policies as $return_policy)
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $return_policy->title }}</h3>
                        <div class="text-gray-700 prose">
                            {!! $return_policy->description !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
