<?php

function wpc_get_product_attributes_html($product_id) {
    $product = wc_get_product($product_id);
    $attributes = $product->get_attributes();

    if (empty($attributes)) {
        return 'No attributes found.';
    }

    $output = '<ul>';
    foreach ($attributes as $attr_name => $attribute) {
        $output .= '<li>' . esc_html(wc_attribute_label($attr_name)) . ': ' . esc_html(implode(', ', $product->get_attribute($attr_name))) . '</li>';
    }
    $output .= '</ul>';

    return $output;
}
