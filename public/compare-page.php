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
    $image_size = get_option('wpc_product_image_size', 'thumbnail');  // Default to 'thumbnail'
    $image_width = get_option('wpc_product_image_width', '150');
    $image_height = get_option('wpc_product_image_height', '150');
    
    // Start container for the grid layout
    echo '<div class="compare-table-product">';
    echo '<div class="wpc-compare-grid">';

    foreach ($compare_list as $product_id) {
        $product = wc_get_product($product_id);
        if (!$product) continue;

        // Start individual product container
        echo '<div class="compare-item" data-product-id="' . esc_attr($product_id) . '">';
        
        // Product Info Container (image, name, rating, price, remove button)
        echo '<div class="product-info">';
        
        // Product Image
        if (get_option('wpc_show_product_image', 'yes') === 'yes') {
            $product_image = $product->get_image('full');  // Get product image with selected size
            echo '<div class="product-image" style="width:' . esc_attr($image_width) . 'px; height:' . esc_attr($image_height) . 'px;">' . $product_image . '</div>';
        }

        // Product Name
        if (get_option('wpc_show_product_name', 'yes') === 'yes') {
            echo '<h5>' . esc_html($product->get_name()) . '</h5>';
        }

        // Product Rating (if available)
        if (get_option('wpc_show_product_rating', 'yes') === 'yes') {
            $average_rating = $product->get_average_rating();
            if ($average_rating) {
                echo '<p class="wpc-product-rating"> <span class="wpc-rating-star" style="color: #f5c518; margin-left:4px;">★</span>' . esc_html($average_rating) . '</p>';
            }
        }

        // Stock Status
        if (get_option('wpc_show_product_stock_status', 'yes') === 'yes') {
            if ($product->is_in_stock()) {
                if (get_option('wpc_show_product_price', 'yes') === 'yes' || get_option('wpc_show_product_sale_price', 'yes') === 'yes') {
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
                echo '<p style="color: #81858b; ">ناموجود</p>';
            }
        }

        // Remove Button
        echo '<button class="wpc-remove-product button" data-product-id="' . esc_attr($product_id) . '">x</button>';
        echo '</div>'; // Close product-info container
        echo '</div>'; // Close individual product container
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
?>
