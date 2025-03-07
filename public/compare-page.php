<?php

if (!defined('ABSPATH')) exit;

function wpc_render_compare_page() {
    $compare_list = isset($_SESSION['wpc_compare_list']) ? $_SESSION['wpc_compare_list'] : [];

    echo '<h2>Product Compare</h2>';

    if (empty($compare_list)) {
        echo '<p>No products in compare list.</p>';
        return;
    }

    echo '<table class="compare-table">';
    echo '<tr><th>Product</th><th>Price</th><th>Attributes</th></tr>';

    foreach ($compare_list as $product_id) {
        $product = wc_get_product($product_id);
        if (!$product) continue;

        echo '<tr>';
        echo '<td>' . esc_html($product->get_name()) . '</td>';
        echo '<td>' . wc_price($product->get_price()) . '</td>';
        echo '<td>' . wpc_get_product_attributes_html($product_id) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

?>
