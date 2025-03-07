<?php

function wpc_get_product_attributes_html($product_id) {
    $product = wc_get_product($product_id);
    $attributes = $product->get_attributes();

    if (empty($attributes)) {
        return 'No attributes found.';
    }

    $output = '<ul>';
    foreach ($attributes as $attr_name => $attribute) {
        // Getting the attribute label (name)
        $attr_label = wc_attribute_label($attr_name);
        $attr_label = urldecode($attr_label); // Decode URL encoding (like %20 to space)
        $attr_label = html_entity_decode($attr_label, ENT_QUOTES, 'UTF-8'); // Decode HTML entities (like &quot; to ")

        // Get the value of the attribute, ensuring it's decoded properly
        $attr_value = $product->get_attribute($attr_name);

        // Decode URL-encoded values and HTML entities to ensure proper display
        $attr_value = urldecode($attr_value); // Decode URL encoding (like %20 to space)
        $attr_value = html_entity_decode($attr_value, ENT_QUOTES, 'UTF-8'); // Decode HTML entities (like &quot; to ")

        // Check if the attribute value is an array (multiple values), then implode them
        if (is_array($attr_value)) {
            $output .= '<li>' . esc_html($attr_label) . ': ' . esc_html(implode(', ', $attr_value)) . '</li>';
        } else {
            $output .= '<li>' . esc_html($attr_label) . ': ' . esc_html($attr_value) . '</li>';
        }
    }
    $output .= '</ul>';

    return $output;
}
