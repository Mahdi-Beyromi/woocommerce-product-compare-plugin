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
});
