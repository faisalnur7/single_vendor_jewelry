@extends('frontend.layouts.main')
@section('title','Stainless Steel Jewelry')
@section('contents')
    @include('frontend.partials._breadcrumbs')
    <!-- Products you may like Section -->
    <section class="py-12 px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2">
            @foreach ($products as $product)
                @include('frontend.partials._product_card')
            @endforeach
        </div>
    </section>
@endsection

