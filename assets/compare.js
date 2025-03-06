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
                    alert('Product added to compare list!');
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
