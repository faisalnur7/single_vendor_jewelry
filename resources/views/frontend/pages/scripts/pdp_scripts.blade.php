<script>
    $(function() {
        // Swiper initialization
        new Swiper('.thumbnailSwiper', {
            slidesPerView: 5,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        const $img = $("#mainImage");
        const $lens = $("#lens");
        const $result = $("#result");
        const $zoomWrapper = $("#zoomWrapper");

        const zoom = 3;

        // Mouse enter
        $img.on("mouseenter", function() {
            $lens.show();
            $zoomWrapper.addClass("fixed").show();
            $result.css("background-image", `url('${$img.attr("src")}')`);
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            $('body').css({
                'overflow': 'hidden',
                'padding-right': `${scrollbarWidth}px`
            });
            $('#productDetailsSection').addClass('blurred'); // blur the details
        });

        $img.on("mouseleave", function() {
            $lens.hide();
            $zoomWrapper.removeClass("fixed").hide();
            $('body').css({
                'overflow': '',
                'padding-right': ''
            });

            $('#productDetailsSection').removeClass('blurred'); // remove blur
        });


        // Mouse move
        $img.on("mousemove", function(e) {
            const bounds = $img[0].getBoundingClientRect();
            const lensWidth = $result.outerWidth() / zoom;
            const lensHeight = $result.outerHeight() / zoom;

            $lens.css({
                width: lensWidth + "px",
                height: lensHeight + "px",
            });

            let x = e.clientX - bounds.left - lensWidth / 2;
            let y = e.clientY - bounds.top - lensHeight / 2;

            x = Math.max(0, Math.min(x, bounds.width - lensWidth));
            y = Math.max(0, Math.min(y, bounds.height - lensHeight));

            $lens.css({
                left: x + "px",
                top: y + "px",
            });

            const ratioX = $img[0].naturalWidth / $img.width();
            const ratioY = $img[0].naturalHeight / $img.height();

            const bgPosX = x * ratioX;
            const bgPosY = y * ratioY;

            $result.css({
                "background-size": `${$img[0].naturalWidth * zoom}px ${$img[0].naturalHeight * zoom}px`,
                "background-position": `-${bgPosX * zoom}px -${bgPosY * zoom}px`,
            });
        });

        // Change image function for variant rows or thumbnails
        window.changeImage = function(src, el = null) {
            const $img = $("#mainImage");
            const $result = $("#result");
            const product_details = $(el).data('product_details');

            // Update the selected row style
            $(".variant_row").removeClass("border-gray-700");
            $(".sw-item").removeClass("border-gray-700");
            if (el) {
                $(el).addClass("border-gray-700");
            }
            $('.product_details').html(product_details);

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

            $('[id^="qty-"]').each(function() {
                let qty = parseInt($(this).text());
                if (qty > 0) {
                    let index = $(this).attr('id').split('-')[1];
                    let price = parseFloat($('[data-index="' + index + '"]').first().data('price'));
                    totalItems += qty;
                    totalPrice += qty * price;
                }
            });

            $('#cartTotal').text(`(${totalItems} items - $${totalPrice.toFixed(2)})`);
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

    });


</script>
