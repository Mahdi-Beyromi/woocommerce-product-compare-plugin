<?php

if (!defined('ABSPATH')) exit;

function wpc_render_compare_page() {
    $compare_list = isset($_SESSION['wpc_compare_list']) ? $_SESSION['wpc_compare_list'] : [];

    echo '<h2>Product Compare</h2>';

    if (empty($compare_list)) {
        echo '<p>No products in compare list.</p>';
        return;
    }

    // Start container for the grid layout
    echo '<div class="compare-grid">';

    foreach ($compare_list as $product_id) {
        $product = wc_get_product($product_id);
        if (!$product) continue;

        // Start individual product container
        echo '<div class="compare-item" data-product-id="' . esc_attr($product_id) . '">';
        
        // Product Info Container (image, name, rating, price, remove button)
        echo '<div class="product-info">';
        
        // Product Image
        $product_image = $product->get_image(); // Get product image
        echo '<div class="product-image">' . $product_image . '</div>';
        
        // Product Name
        echo '<h5>' . esc_html($product->get_name()) . '</h5>';

        // Product Rating (if available)
        $average_rating = $product->get_average_rating();
        if ($average_rating) {
            echo '<p><strong>Rating: </strong>' . esc_html($average_rating) . ' / 5</p>';
        }

        $show_add_to_cart = get_option('wpc_show_add_to_cart_button', 'yes') === 'yes';

        if ($product->is_in_stock()) {
            $sale_price = $product->get_sale_price();
            $regular_price = $product->get_regular_price();
        
            if ($sale_price) {
                echo '<p><strong>Price: </strong><span class="regular-price" style="text-decoration: line-through;">' . wc_price($regular_price) . '</span> ' . wc_price($sale_price) . '</p>';
            } else {
                echo '<p><strong>Price: </strong>' . wc_price($regular_price) . '</p>';
            }
        
            if ($show_add_to_cart) {
                echo '<form class="add-to-cart-form" method="post" action="' . esc_url(WC()->cart->get_cart_url()) . '">
                        <input type="hidden" name="add-to-cart" value="' . esc_attr($product_id) . '" />
                        <button type="submit" class="add-to-cart-button button">Add to Cart</button>
                    </form>';
            }
        } else {
            // If the product is out of stock, display "Out of Stock"
            echo '<p><strong>Availability: </strong>Out of Stock</p>';
        }

        // Remove Button
        echo '<button class="wpc-remove-product button" data-product-id="' . esc_attr($product_id) . '">x</button>';
        echo '</div>'; // Close product-info container
        // Product Attributes Container
        echo '<div class="product-attributes">';
        echo '<h4>Attributes:</h4>';
        echo wpc_get_product_attributes_html($product_id);
        echo '</div>'; // Close product-attributes container

        echo '</div>'; // Close individual product container
    }

    echo '</div>'; // Close compare-grid container
}
?>
