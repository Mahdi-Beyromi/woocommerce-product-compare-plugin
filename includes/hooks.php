<?php

// Hook to display compare button after add to cart button
add_action( 'woocommerce_after_add_to_cart_button', 'wpc_add_compare_button', 20 );

function wpc_add_compare_button() {
    global $product;
    
    if ( ! is_product() ) {
        return;
    }
    
    // Compare button with icon HTML
    echo '<a class="wpc-product-compare-button button" data-product-id="' . $product->get_id() . '">';
    echo '<i class="fa fa-exchange-alt"></i>'; // Font Awesome icon
    echo '</a>';

    echo '<div id="wpc-compare-overlay"></div>';
    echo '<div id="wpc-compare-notification">
        <p>کالا به لیست مقایسه اضافه شد!</p><br>
        <button id="wpc-go-to-compare">رفتن به صفحه مقایسه</button>
        <a href="javascript:void(0)" id="wpc-dismiss-notification">بستن</a>
    </div>';
}


require_once WPC_PLUGIN_DIR . 'public/enqueue-scripts.php';

add_action('wp_enqueue_scripts', 'wpc_enqueue_scripts');


add_filter('the_content', 'wpc_override_compare_page_content');

function wpc_override_compare_page_content($content) {
    if (is_page('wpc-compare')) {
        ob_start();
        wpc_render_compare_page();
        return ob_get_clean();
    }
    return $content;
}


?>
