<script>
    $(document).ready(function() {
        function updateCart(productId, quantity) {
            $.ajax({
                url: "{{ route('cart.update') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        const input = $(`.quantity-input[data-id="${productId}"]`);
                        const price = parseFloat($(`[data-price][data-id="${productId}"]`).data(
                            'price'));

                        if (!isNaN(price) && !isNaN(quantity)) {
                            const newSubtotal = (price * quantity).toFixed(2);
                            $(`.subtotal[data-id="${productId}"]`).text('$' + newSubtotal);
                        }

                        // Recalculate total
                        let total = 0;
                        $('.quantity-input').each(function() {
                            const qty = parseInt($(this).val());
                            const id = $(this).data('id');
                            const price = parseFloat($(`[data-price][data-id="${id}"]`)
                                .data('price'));

                            if (!isNaN(qty) && !isNaN(price)) {
                                total += price * qty;
                            }
                        });
                        $('.cart-total').text('Total: $' + total.toFixed(2));

                        toastr.success("Cart updated.");
                    }
                },
                error: function(xhr) {
                    alert('Error updating cart. Please try again.');
                }
            });
        }


        $('.increase-qty').on('click', function() {
            var id = $(this).data('id');
            var input = $('.quantity-input[data-id="' + id + '"]');
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                input.val(currentVal + 1);
                updateCart(id, currentVal + 1);
            }
        });

        $('.decrease-qty').on('click', function() {
            var id = $(this).data('id');
            var input = $('.quantity-input[data-id="' + id + '"]');
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal) && currentVal > 1) {
                input.val(currentVal - 1);
                updateCart(id, currentVal - 1);
            }
        });

        // Optional: trigger update if quantity is manually typed
        $('.quantity-input').on('change', function() {
            var id = $(this).data('id');
            var qty = parseInt($(this).val());
            if (!isNaN(qty) && qty >= 1) {
                updateCart(id, qty);
            } else {
                $(this).val(1);
                updateCart(id, 1);
            }
        });
    });

    $('.delete-cart-item-btn').on('click', function() {
        const productId = $(this).data('id');
        const $cartItem = $(`[data-id="${productId}"]`);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000000',
            cancelButtonColor: '#F97316',
            confirmButtonText: 'Remove',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/cart/remove/${productId}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove item from DOM
                            $cartItem.remove();

                            // Recalculate total
                            let total = 0;
                            $('.quantity-input').each(function() {
                                const qty = parseInt($(this).val());
                                const id = $(this).data('id');
                                const price = parseFloat($(
                                    `[data-price][data-id="${id}"]`).data(
                                    'price'));

                                if (!isNaN(qty) && !isNaN(price)) {
                                    total += price * qty;
                                }
                            });
                            $('.cart-total').text('Total: $' + total.toFixed(2));


                            // If cart is now empty
                            if ($('.quantity-input').length === 0) {
                                $('.space-y-4').remove();
                                $('.cart-total').remove();
                                $('.checkout-trigger').remove();
                                $('.max-w-7xl').append(`
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mt-4" role="alert">
                                            <p class="font-bold">Your cart is empty!</p>
                                            <p>Start adding products to your cart.</p>
                                        </div>
                                    `);
                            }

                            toastr.success("Item removed from cart.");
                        }
                    },
                    error: function() {
                        toastr.error("Error removing item. Try again.");
                    }
                });
            }
        });
    });
</script>
