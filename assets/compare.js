jQuery(document).ready(function($) {
    $('.wpc-product-compare-button').on('click', function() {
        var productId = $(this).data('product-id');
        $('body').append('<div id="loading-overlay"><div id="loading-spinner"></div></div>');

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
                    $('#wpc-compare-overlay').addClass('show');
                    $('#loading-overlay').remove();
                } else {
                    alert('Failed: ' + response.data);
                    $('#loading-overlay').remove();
                }
            },
            error: function() {
                alert('AJAX request failed!');
                $('#loading-overlay').remove();
            }
        });
    });

    $('#wpc-go-to-compare').on('click', function() {
        window.location.href = woocommerce_compare.compare_page_url;
    });

    $('#wpc-dismiss-notification').on('click', function() {
        $('#wpc-compare-notification').removeClass('show');
        $('#wpc-compare-overlay').removeClass('show');
        
    });

    $('.wpc-remove-product').on('click', function() {
        var productId = $(this).data('product-id');
        $('body').append('<div id="loading-overlay"><div id="loading-spinner"></div></div>');

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
                    $('#loading-overlay').remove();
                    
                    // If no products are left, show a message
                    if ($('.compare-grid .compare-item').length === 0) {
                        $('.compare-grid').html('<p>No products in compare list.</p>');
                    }
                } else {
                    alert('Failed: ' + response.data);
                    $('#loading-overlay').remove();
                }
            },
            error: function() {
                alert('AJAX request failed!');
                $('#loading-overlay').remove();
            }
        });
    });

    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();

        var productId = $(this).closest('form').find('input[name="add-to-cart"]').val();

        $('body').append('<div id="loading-overlay"><div id="loading-spinner"></div></div>');

        $.ajax({
            url: woocommerce_compare.ajax_url,
            type: 'POST',
            data: {
                action: 'wpc_add_to_cart',
                nonce: woocommerce_compare.nonce,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Optionally, you can update the cart count or other elements
                    setTimeout(function() {
                        location.reload();
                    }, 100);
                } else {
                    alert('Failed to add to cart.');
                    $('#loading-overlay').remove();
                }
            },
            error: function() {
                alert('AJAX request failed!');
                $('#loading-overlay').remove(); 
            }
        });
    });
});
