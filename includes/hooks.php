<?php

// Hook to display compare button on product pages
add_action( 'woocommerce_after_single_product', 'wpc_add_compare_button', 20 );

function wpc_add_compare_button() {
    global $product;
    
    if ( ! is_product() ) {
        return;
    }
    
    // Compare button HTML
    echo '<button class="compare-button" data-product-id="' . $product->get_id() . '">Add to Compare</button>';

    echo '<div id="wpc-compare-notification">
        Product added to compare list!<br><br>
        <button id="wpc-go-to-compare">Go to Compare Page</button>
        <a href="javascript:void(0)" id="wpc-dismiss-notification">Dismiss</a>
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
