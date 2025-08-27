@extends('frontend.layouts.main')
@section('title', 'My Wishlist')

@section('contents')
    <div class="container mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">My Wishlist (Guest)</h2>

        <div id="guest-wishlist" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <p class="col-span-full text-gray-600 text-center">Loading your wishlist...</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var wishlistContainer = $("#guest-wishlist");
            if (!wishlistContainer.length) return; // Safety check

            var wishlist = JSON.parse(sessionStorage.getItem('wishlist')) || [];

            if (wishlist.length === 0) {
                wishlistContainer.html(
                    '<p class="col-span-full text-gray-600 text-center">Your wishlist is empty.</p>');
                return;
            }

            // Fetch product details via AJAX
            $.ajax({
                url: "{{ route('guest_wishlist_products') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: wishlist
                },
                success: function(response) {
                    wishlistContainer.empty();
                    $.each(response.products, function(index, product) {
                        console.log(product);
                        var card = `
                                    <div class="flex flex-col product_card">
                                        <a href="/product/${product.slug}">
                                            <!-- Image with overlay icons -->
                                            <div class="relative bg-white border rounded-none group overflow-hidden">
                                                <img src="/${product.image}" alt="${product.name}"
                                                    class="mx-auto transition-transform duration-[3000ms] group-hover:scale-[1.5]" />
                                                <!-- Icons -->
                                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 transform flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                                    <button class="bg-white rounded-full shadow flex justify-center items-center w-12 h-12 transition-colors duration-300 hover:bg-black group/icon">
                                                        <i class="fa-solid fa-eye text-gray-700 transition-colors duration-300 group-hover/icon:text-white"></i>
                                                    </button>

                                                    <button class="remove_guest_wishlist bg-white rounded-full shadow flex justify-center items-center w-12 h-12 transition-colors duration-300 hover:bg-black group/icon" data-id="${product.id}">
                                                        <i class="fa-solid fa-trash text-red-600"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Product title -->
                                            <div class="text-md overflow-hidden whitespace-nowrap text-ellipsis w-full mt-2">
                                                <span class="block">${product.name}</span>
                                            </div>
                                        </a>
                                    </div>`;
                        wishlistContainer.append(card);
                    });
                },
                error: function() {
                    wishlistContainer.html(
                        '<p class="col-span-full text-red-600 text-center">Failed to load wishlist.</p>'
                        );
                }
            });

            // Remove guest wishlist item
            $(document).on("click", ".remove_guest_wishlist", function(e) {
                e.preventDefault();
                var productId = $(this).data("id");
                var wishlist = JSON.parse(sessionStorage.getItem('wishlist')) || [];
                wishlist = $.grep(wishlist, function(id) {
                    return id != productId;
                });
                sessionStorage.setItem('wishlist', JSON.stringify(wishlist));

                toastr.info("Product removed from wishlist.");
                $(this).closest(".product_card").remove();

                if (wishlist.length === 0) {
                    wishlistContainer.html(
                        '<p class="col-span-full text-gray-600 text-center">Your wishlist is empty.</p>'
                        );
                }
            });
        });
    </script>

@endsection
