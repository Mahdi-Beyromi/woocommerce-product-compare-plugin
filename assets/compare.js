jQuery(document).ready(function($) {
    // Add to compare button click event
    $('.wpc-product-compare-button').on('click', function(e) {
        e.preventDefault();
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
                    alert('خطا: ' + response.data);
                    $('#loading-overlay').remove();
                }
            },
            error: function() {
                alert('درخواست AJAX با مشکل مواجه شد!');
                $('#loading-overlay').remove();
            }
        });
    });

    // Go to compare page
    $('#wpc-go-to-compare').on('click', function(e) {
        e.preventDefault();
        window.location.href = woocommerce_compare.compare_page_url;
    });

    // Dismiss notification
    $('#wpc-dismiss-notification').on('click', function(e) {
        e.preventDefault();
        $('#wpc-compare-notification').removeClass('show');
        $('#wpc-compare-overlay').removeClass('show');
    });

    // Remove product from compare
    $('.wpc-remove-product').on('click', function(e) {
        e.preventDefault();
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
                    $('.compare-item[data-product-id="' + productId + '"]').remove();
                    $('#loading-overlay').remove();
                    if ($('.compare-grid .compare-item').length === 0) {
                        $('.compare-grid').html('<p>هیچ کالایی برای مقایسه موجود نیست.</p>');
                    }
                } else {
                    alert('خطا: ' + response.data);
                    $('#loading-overlay').remove();
                }
            },
            error: function() {
                alert('درخواست AJAX با مشکل مواجه شد!');
                $('#loading-overlay').remove();
            }
        });
    });

    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();
    
        var $form = $(this).closest('form');
        var productId = $form.find('input[name="add-to-cart"]').val();
        
        // Check if product is variable and collect selected variations
        if ($form.hasClass('variations_form')) {
            var variationId = $form.find('input[name="variation_id"]').val();
            var attributes = {};
    
            $form.find('.variations select').each(function() {
                var attributeName = $(this).attr('name');
                var attributeValue = $(this).val();
                if (attributeValue) {
                    attributes[attributeName] = attributeValue;
                }
            });
    
            if (variationId === '' || Object.keys(attributes).length === 0) {
                alert('لطفا ویژگی‌های محصول را انتخاب کنید.');
                return;
            }
    
            // Now send this data in AJAX request
            $('body').append('<div id="loading-overlay"><div id="loading-spinner"></div></div>');
    
            $.ajax({
                url: woocommerce_compare.ajax_url,
                type: 'POST',
                data: {
                    action: 'wpc_add_to_cart',
                    nonce: woocommerce_compare.nonce,
                    product_id: productId,
                    variation_id: variationId,
                    attributes: attributes
                },
                success: function(response) {
                    if (response.success) {
                        setTimeout(function() {
                            location.reload();
                        }, 100);
                    } else {
                        alert('افزودن به سبد خرید با مشکل مواجه شد.');
                        $('#loading-overlay').remove();
                    }
                },
                error: function() {
                    alert('درخواست AJAX با مشکل مواجه شد!');
                    $('#loading-overlay').remove();
                }
            });
        } else {
            // For simple products, proceed as usual
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
                        setTimeout(function() {
                            location.reload();
                        }, 100);
                    } else {
                        alert('افزودن به سبد خرید با مشکل مواجه شد.');
                        $('#loading-overlay').remove();
                    }
                },
                error: function() {
                    alert('درخواست AJAX با مشکل مواجه شد!');
                    $('#loading-overlay').remove();
                }
            });
        }
    });    
});
