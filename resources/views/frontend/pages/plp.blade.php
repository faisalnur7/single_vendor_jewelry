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
@section('scripts')
<script>
$(document).ready(function() {
    $('.wishlist_btn').on('click', function(e) {
        e.preventDefault();
        let button = $(this);
        let productId = button.data('product_id');

        $.ajax({
            url: "{{ route('user_wishlist_store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    alert(response.success);
                } else if (response.error) {
                    alert(response.error);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON;
                    alert(errors.error);
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });

});
</script>
@endsection

