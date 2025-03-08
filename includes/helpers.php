<?php

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
