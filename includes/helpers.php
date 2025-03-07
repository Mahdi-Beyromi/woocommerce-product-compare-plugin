<?php

function wpc_get_product_attributes_html($compare_list) {
    // Collect all attributes from all products
    $all_attributes = wpc_get_all_attributes_for_compare($compare_list);

    echo '<div class="compare-attributes-list">';

    // Each attribute as a separate section
    foreach ($all_attributes as $attr_name => $attr_label_raw) {
        $attr_label = urldecode($attr_label_raw); // Fix encoding issue
        $attr_label = html_entity_decode($attr_label, ENT_QUOTES, 'UTF-8'); // Just in case

        echo '<div class="compare-attribute-group">';
        echo '<strong class="attribute-title">' . esc_html($attr_label) . '</strong>';
        echo '<ul class="attribute-values wpc-compare-grid">';

        foreach ($compare_list as $product_id) {
            $product = wc_get_product($product_id);
            $attr_value = $product->get_attribute($attr_name);

            // Fix attribute value encoding too (just to be extra safe)
            $attr_value = urldecode($attr_value);
            $attr_value = html_entity_decode($attr_value, ENT_QUOTES, 'UTF-8');

            echo '<li class="attribute-value-item"><span>' . (!empty($attr_value) ? esc_html($attr_value) : '') . '</span></li>';
        }

        echo '</ul>';
        echo '</div>';
    }

    echo '</div>';
}

function wpc_get_all_attributes_for_compare($product_ids) {
    $all_attributes = [];

    foreach ($product_ids as $product_id) {
        $product = wc_get_product($product_id);
        $attributes = $product->get_attributes();

        foreach ($attributes as $attr_name => $attribute) {
            $label = wc_attribute_label($attr_name);
            $label = urldecode($label); // Fix encoding
            $label = html_entity_decode($label, ENT_QUOTES, 'UTF-8'); // Double-check for HTML entities

            $all_attributes[$attr_name] = $label;
        }
    }

    return $all_attributes;
}
