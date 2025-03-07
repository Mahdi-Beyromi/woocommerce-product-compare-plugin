jQuery(document).ready(function($) {
    $('.compare-button').on('click', function() {
        var productId = $(this).data('product-id');

        $.ajax({
            url: woocommerce_compare.ajax_url,
            type: 'POST',
            data: {
                action: 'add_to_compare',
                nonce: woocommerce_compare.nonce,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    $('#wpc-compare-notification').addClass('show');
                } else {
                    alert('Failed: ' + response.data);
                }
            },
            error: function() {
                alert('AJAX request failed!');
            }
        });
    });

    $('#wpc-go-to-compare').on('click', function() {
        window.location.href = woocommerce_compare.compare_page_url;
    });

    $('#wpc-dismiss-notification').on('click', function() {
        $('#wpc-compare-notification').removeClass('show');
    });

    $('.wpc-remove-product').on('click', function() {
        var productId = $(this).data('product-id');

        $.ajax({
            url: woocommerce_compare.ajax_url,
            type: 'POST',
            data: {
                action: 'remove_from_compare',
                nonce: woocommerce_compare.nonce,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Remove the product from the compare list on the page immediately
                    $('.compare-item[data-product-id="' + productId + '"]').remove();
                    
                    // If no products are left, show a message
                    if ($('.compare-grid .compare-item').length === 0) {
                        $('.compare-grid').html('<p>No products in compare list.</p>');
                    }
                } else {
                    alert('Failed: ' + response.data);
                }
            },
            error: function() {
                alert('AJAX request failed!');
            }
        });
    });
});
