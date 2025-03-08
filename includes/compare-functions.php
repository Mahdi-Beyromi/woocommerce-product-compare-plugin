<?php
function wpc_add_to_compare() {
    check_ajax_referer('wpc_compare_nonce', 'nonce');
    
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Product ID is missing'));
    }

    $product_id = intval($_POST['product_id']);
    
    // Start session if it's not started
    if (!session_id()) {
        session_start();
    }

    $compare_list = isset($_SESSION['wpc_compare_list']) ? $_SESSION['wpc_compare_list'] : array();
    
    if (!in_array($product_id, $compare_list)) {
        $compare_list[] = $product_id;
    }
    
    $_SESSION['wpc_compare_list'] = $compare_list;

    wp_send_json_success(array('message' => 'Product added to compare list', 'compare_list' => $compare_list));
}

add_action('wp_ajax_add_to_compare', 'wpc_add_to_compare');
add_action('wp_ajax_nopriv_add_to_compare', 'wpc_add_to_compare');

function wpc_remove_from_compare() {
    check_ajax_referer('wpc_compare_nonce', 'nonce');

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (!$product_id) {
        wp_send_json_error('Invalid product.');
    }

    if (!isset($_SESSION['wpc_compare_list'])) {
        $_SESSION['wpc_compare_list'] = [];
    }

    $_SESSION['wpc_compare_list'] = array_diff($_SESSION['wpc_compare_list'], [$product_id]);

    wp_send_json_success(['message' => 'Product removed from compare list.']);
}
add_action('wp_ajax_remove_from_compare', 'wpc_remove_from_compare');
add_action('wp_ajax_nopriv_remove_from_compare', 'wpc_remove_from_compare');


function wpc_add_product_to_cart() {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
        $attributes = isset($_POST['attributes']) ? $_POST['attributes'] : array();

        // If it's a variable product, add variation
        if ($variation_id > 0) {
            $product = wc_get_product($variation_id);
        } else {
            $product = wc_get_product($product_id);
        }

        // Ensure product exists and add to cart
        if ($product) {
            $cart_item_data = array();
            if (!empty($attributes)) {
                // Process attributes for variations
                $cart_item_data['attributes'] = $attributes;
            }
            
            // Add product (or variation) to cart
            WC()->cart->add_to_cart($product_id, 1, $variation_id, $attributes, $cart_item_data);

            wp_send_json_success(array(
                'message' => 'محصول به سبد خرید اضافه شد!',
                'cart_count' => WC()->cart->get_cart_contents_count()
            ));
        } else {
            wp_send_json_error(array('message' => 'محصول نامعتبر است.'));
        }
    } else {
        wp_send_json_error(array('message' => 'شناسه محصول وجود ندارد.'));
    }
}
add_action('wp_ajax_wpc_add_to_cart', 'wpc_add_product_to_cart');
add_action('wp_ajax_nopriv_wpc_add_to_cart', 'wpc_add_product_to_cart');