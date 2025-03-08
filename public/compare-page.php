<?php

if (!defined('ABSPATH')) exit;

function wpc_render_compare_page() {
    $compare_list = isset($_SESSION['wpc_compare_list']) ? $_SESSION['wpc_compare_list'] : [];

    $page_title = get_option('wpc_compare_page_title', 'Product Comparison');
    $table_title = get_option('wpc_compare_table_title', 'Comparison Table');
    $show_add_to_cart = get_option('wpc_show_add_to_cart_button', 'yes') === 'yes';
    
    if (get_option('wpc_show_page_title', 'yes') === 'yes') {
        echo '<h2 style="font-size: 24px;">' . esc_html($page_title) . '</h2>';
    }
    
    if (empty($compare_list)) {
        echo '<p>No products in compare list.</p>';
        return;
    }
    
    if (get_option('wpc_show_table_title', 'yes') === 'yes') {
        echo '<h3 style="font-size: 20px;">' . esc_html($table_title) . '</h3>';
    }

    // Get the product image size option
    // $image_size = get_option('wpc_product_image_size', 'thumbnail');  // Default to 'thumbnail'
    $image_width = get_option('wpc_product_image_width', '150');
    $image_height = get_option('wpc_product_image_height', '150');
    
    // Start container for the grid layout
    echo '<div class="compare-table-product">';
    echo '<div class="wpc-compare-grid">';

    foreach ($compare_list as $product_id) {
        echo wpc_get_product_info_html($product_id, $show_add_to_cart, $image_width, $image_height);
    }
    
    echo '</div>'; // Close wpc-compare-grid container
    if (get_option('wpc_show_product_attribute', 'yes') === 'yes') {
        // Product Attributes Container
        echo '<div class="product-attributes">';
        echo '<h4>مشخصات کلی</h4>';
        echo wpc_get_product_attributes_html($compare_list);
        echo '</div>'; // Close product-attributes container
    }

    echo '</div>'; // Close wpc-compare-grid container
}

function wpc_get_product_info_html($product_id, $show_add_to_cart, $image_width, $image_height) {
    $product = wc_get_product($product_id);
    if (!$product) return '';

    ob_start();
    $product_url = get_permalink($product_id);

    echo '<div class="compare-item" data-product-id="' . esc_attr($product_id) . '">';
    echo '<a href="' . esc_url($product_url) . '" class="product-image-link">';
    echo '<div class="product-info">';

    if (get_option('wpc_show_product_image', 'yes') === 'yes') {
        $product_image = $product->get_image('full');
        echo '<div class="product-image" style="width:' . esc_attr($image_width) . 'px; height:' . esc_attr($image_height) . 'px;">' . $product_image . '</div>';
    }

    if (get_option('wpc_show_product_name', 'yes') === 'yes') {
        echo '<h3>' . esc_html($product->get_name()) . '</h3>';
    }

    if (get_option('wpc_show_product_rating', 'yes') === 'yes') {
        $average_rating = $product->get_average_rating();
        if ($average_rating) {
            echo '<p class="wpc-product-rating"><span class="wpc-rating-star" style="color: #f5c518; margin-left:4px;">★</span>' . esc_html($average_rating) . '</p>';
        }
    }

    if (get_option('wpc_show_product_stock_status', 'yes') === 'yes') {
        if ($product->is_in_stock()) {
            if (get_option('wpc_show_product_price', 'yes') === 'yes') {
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                echo '<p class="wpc-product-price">';
                if ($sale_price) {
                    echo '<span class="regular-price woocommerce-Price-amount amount">' . wc_price($regular_price) . '</span>';
                    echo '<span class="sale-price">' . wc_price($sale_price) . '</span>';
                } else {
                    echo '<span class="regular-price">' . wc_price($regular_price) . '</span>';
                }
                echo '</p>';
            }
            if ($show_add_to_cart) {
                echo '<form class="add-to-cart-form" method="post" action="' . esc_url(WC()->cart->get_cart_url()) . '">
                        <input type="hidden" name="add-to-cart" value="' . esc_attr($product_id) . '" />
                        <button type="submit" class="add-to-cart-button button">افزودن به سبد</button>
                    </form>';
            }
        } else {
            echo '<p style="color: #81858b;">ناموجود</p>';
        }
    }

    echo '<button class="wpc-remove-product button" data-product-id="' . esc_attr($product_id) . '">x</button>';
    echo '</div></a></div>';

    return ob_get_clean();
}


function wpc_get_product_attributes_html($compare_list) {
    $saved_attributes = get_option('wpc_selected_attributes', []);
    $all_attributes = wpc_get_all_attributes_for_compare($compare_list);

    echo '<div class="compare-attributes-list">';

    foreach ($all_attributes as $attr_name => $attr_label_raw) {
        if (!in_array($attr_name, $saved_attributes)) {
            continue;
        }

        $attr_label = urldecode($attr_label_raw);
        $attr_label = html_entity_decode($attr_label, ENT_QUOTES, 'UTF-8');

        echo '<div class="compare-attribute-group">';
        echo '<strong class="attribute-title">' . esc_html($attr_label) . '</strong>';
        echo '<ul class="attribute-values wpc-compare-grid">';

        foreach ($compare_list as $product_id) {
            $product = wc_get_product($product_id);
            $attr_value = $product->get_attribute($attr_name);

            $attr_value = urldecode($attr_value);
            $attr_value = html_entity_decode($attr_value, ENT_QUOTES, 'UTF-8');

            echo '<li class="attribute-value-item"><span>' . (!empty($attr_value) ? esc_html($attr_value) : '') . '</span></li>';
        }

        echo '</ul>';
        echo '</div>';
    }

    echo '</div>';
}



?>
