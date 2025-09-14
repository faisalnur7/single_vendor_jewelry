<script>
    $(function() {
        // Swiper initialization
        new Swiper('.thumbnailSwiper', {
            slidesPerView: 5,
            spaceBetween: 5,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        
        const $lens = $("#lens");
        const $result = $("#result");
        const $zoomWrapper = $("#zoomWrapper");

        // Mouse enter
        const $img = $("#mainImage");
        const zoom = 1.7; // zoom factor

        $img.on("mouseenter", function() {
            $(this).css({
                "transform": `scale(${zoom})`
            });
        });

        $img.on("mousemove", function(e) {
            const bounds = this.getBoundingClientRect();
            const x = ((e.clientX - bounds.left) / bounds.width) * 100;
            const y = ((e.clientY - bounds.top) / bounds.height) * 100;

            $(this).css("transform-origin", `${x}% ${y}%`);
        });

        $img.on("mouseleave", function() {
            $(this).css({
                "transform": "scale(1)",
                "transform-origin": "center center"
            });
        });


        // Change image function for variant rows or thumbnails
        window.changeImage = function(src, el = null) {
            const $img = $("#mainImage");
            const $result = $("#result");
            const weight = $(el).data('weight');

            // Update the selected row style
            $(".variant_row").removeClass("border-gray-700");
            $(".sw-item").removeClass("border-gray-700");
            if (el) {
                $(el).addClass("border-gray-700");
            }
            $('.weight').html(weight);

            // Fade out current image
            $img.removeClass("opacity-100").addClass("opacity-0");

            setTimeout(() => {
                $img.attr("src", src);
                $img.on("load", function() {
                    $img.removeClass("opacity-0").addClass("opacity-100");
                    $result.css("background-image", `url('${src}')`);
                });
            }, 200);
        };

        $(document).on("mouseenter", ".wishlist_btn", function() {
            $(this).find('.heart_icon').removeClass("fa-regular").addClass("fa-solid");
        });

        $(document).on("mouseleave", ".wishlist_btn", function() {
            $(this).find('.heart_icon').removeClass("fa-solid").addClass("fa-regular");
        });

        function updateCartTotal() {
            let totalItems = 0;
            let totalPrice = 0;

            let currentCurrency = $('#currentCurrency').attr('data-currentCurrency');

            $('[id^="qty-"]').each(function() {
                let qty = parseInt($(this).text());
                if (qty > 0) {
                    let index = $(this).attr('id').split('-')[1];

                    // choose price field depending on currency
                    let priceAttr = (currentCurrency === 'RMB') ? 'price_rmb' : 'price';
                    let price = parseFloat($('[data-index="' + index + '"]').first().data(priceAttr));

                    totalItems += qty;
                    totalPrice += qty * price;
                }
            });

            // Update display
            let currencySymbol = (currentCurrency === 'RMB') ? '¥' : '$';
            $('#cartTotal').text(`(${totalItems} items - ${currencySymbol}${totalPrice.toFixed(2)})`);
        }


        $('.qty-increase').click(function() {
            var index = $(this).data('index');
            var qtyElem = $('#qty-' + index);
            var current = parseInt(qtyElem.text());
            qtyElem.text(current + 1);
            updateCartTotal();
        });

        $('.qty-decrease').click(function() {
            var index = $(this).data('index');
            var qtyElem = $('#qty-' + index);
            var current = parseInt(qtyElem.text());
            if (current > 0) {
                qtyElem.text(current - 1);
                updateCartTotal();
            }
        });




        $('.add_to_cart_btn').click(function() {
            const itemsToAdd = [];

            $('[id^="qty-"]').each(function() {
                const qty = parseInt($(this).text());
                if (qty > 0) {
                    const index = $(this).attr('id').split('-')[1];
                    const price = $('[data-index="' + index + '"]').first().data('price');
                    const price_rmb = $('[data-index="' + index + '"]').first().data('price_rmb');
                    const productId = $('[data-index="' + index + '"]').first().data('product_id');
                    const variant = @json($product->variants);

                    itemsToAdd.push({
                        product_id: productId,
                        variant_index: index,
                        quantity: qty,
                        price: price,
                        price_rmb: price_rmb,
                    });
                }
            });

            if (itemsToAdd.length === 0) {
                toastr.warning("Please select at least one item.");
                return;
            }

            // Send one by one — or batch if you create such backend support

            $.ajax({
                url: "{{ route('add_to_cart') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    items: itemsToAdd
                },
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        toastr.success(res.message);
                        $('.cart_count').text(res.cart)
                        $('.cart_count').removeClass('bg-transparent')
                        $('.cart_count').addClass('bg-red-500')
                    }
                },
                error: function(err) {
                    if (err.status === 401) {
                        toastr.danger('Please login to add items to cart.');
                        window.location.href = '/login';
                    } else {
                        toastr.danger('Failed to add item to cart.');
                    }
                }
            });
        });

        $(".descToggle").click(function() {
            let content = $(this).closest(".border").find(".descContent");

            // Close all other accordions
            $(".descContent").not(content).slideUp();
            $(".descToggle").not(this).text("+");

            // Toggle this one
            content.slideToggle();
            $(this).text($(this).text() === "–" ? "+" : "–");
        });

    });


</script>
