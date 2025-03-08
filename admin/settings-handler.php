<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_init', 'wpc_register_settings');

function wpc_register_settings() {
    // Register settings for both titles and their show options
    register_setting('wpc_options_group', 'wpc_compare_page_title');
    register_setting('wpc_options_group', 'wpc_compare_table_title');
    register_setting('wpc_options_group', 'wpc_show_add_to_cart_button');
    register_setting('wpc_options_group', 'wpc_show_page_title');
    register_setting('wpc_options_group', 'wpc_show_table_title');
    // register_setting('wpc_options_group', 'wpc_product_image_size');
    register_setting('wpc_options_group', 'wpc_product_image_width');
    register_setting('wpc_options_group', 'wpc_product_image_height');
    
    // Add settings for each product detail
    register_setting('wpc_options_group', 'wpc_show_product_image');
    register_setting('wpc_options_group', 'wpc_show_product_name');
    register_setting('wpc_options_group', 'wpc_show_product_price');
    // register_setting('wpc_options_group', 'wpc_show_product_sale_price');
    register_setting('wpc_options_group', 'wpc_show_product_rating');
    register_setting('wpc_options_group', 'wpc_show_product_stock_status');
    register_setting('wpc_options_group', 'wpc_show_product_attribute');

    // Registering fields
    add_settings_section('wpc_main_section', '', null, 'wpc-settings');

    add_settings_field('wpc_compare_page_title', 'Compare Page Title', 'wpc_compare_page_title_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_compare_table_title', 'Compare Table Title', 'wpc_compare_table_title_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_show_add_to_cart_button', 'Show Add to Cart Button in Compare Page', 'wpc_show_add_to_cart_button_callback', 'wpc-settings', 'wpc_main_section');
    // add_settings_field('wpc_product_image_size','Product Image Size','wpc_product_image_size_callback','wpc-settings','wpc_main_section');
    add_settings_field('wpc_product_image_width','Product Image Width (px)','wpc_product_image_width_callback','wpc-settings','wpc_main_section');   
    add_settings_field('wpc_product_image_height','Product Image Height (px)','wpc_product_image_height_callback','wpc-settings','wpc_main_section');

    // Fields for product details visibility
    add_settings_field('wpc_show_product_image', 'Show Product Image', 'wpc_show_product_image_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_show_product_name', 'Show Product Name', 'wpc_show_product_name_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_show_product_price', 'Show Product Price', 'wpc_show_product_price_callback', 'wpc-settings', 'wpc_main_section');
    // add_settings_field('wpc_show_product_sale_price', 'Show Product Sale Price', 'wpc_show_product_sale_price_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_show_product_rating', 'Show Product Rating', 'wpc_show_product_rating_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_show_product_stock_status', 'Show Product Stock Status', 'wpc_show_product_stock_status_callback', 'wpc-settings', 'wpc_main_section');
    add_settings_field('wpc_show_product_attribute', 'Show Product Attribute', 'wpc_show_product_attribute_callback', 'wpc-settings', 'wpc_main_section');
}

// Callbacks
function wpc_compare_page_title_callback() {
    $value = get_option('wpc_compare_page_title', 'Product Comparison');
    echo '<div class="wpc-input-container">
            <input type="text" name="wpc_compare_page_title" value="' . esc_attr($value) . '" class="wpc-input" />
            <label for="wpc_show_page_title" class="wpc-checkbox-label">Show</label>
            <input type="checkbox" name="wpc_show_page_title" value="yes"' . checked(get_option('wpc_show_page_title', 'yes'), 'yes', false) . ' class="wpc-checkbox" />
          </div>';
}

function wpc_compare_table_title_callback() {
    $value = get_option('wpc_compare_table_title', 'Comparison Table');
    echo '<div class="wpc-input-container">
            <input type="text" name="wpc_compare_table_title" value="' . esc_attr($value) . '" class="wpc-input" />
            <label for="wpc_show_table_title" class="wpc-checkbox-label">Show</label>
            <input type="checkbox" name="wpc_show_table_title" value="yes"' . checked(get_option('wpc_show_table_title', 'yes'), 'yes', false) . ' class="wpc-checkbox" />
          </div>';
}

function wpc_show_add_to_cart_button_callback() {
    $checked = get_option('wpc_show_add_to_cart_button', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_add_to_cart_button" value="yes"' . checked($checked, true, false) . ' />';
}

// function wpc_product_image_size_callback() {
//     $value = get_option('wpc_product_image_size', 'thumbnail');  // مقدار پیش‌فرض "thumbnail"
//     echo '<select name="wpc_product_image_size">
//             <option value="thumbnail"' . selected($value, 'thumbnail', false) . '>Thumbnail</option>
//             <option value="medium"' . selected($value, 'medium', false) . '>Medium</option>
//             <option value="large"' . selected($value, 'large', false) . '>Large</option>
//             <option value="full"' . selected($value, 'full', false) . '>Full Size</option>
//           </select>';
// }

function wpc_product_image_width_callback() {
    $value = get_option('wpc_product_image_width', '150'); 
    echo '<input type="number" name="wpc_product_image_width" value="' . esc_attr($value) . '" class="wpc-input" /> px';
}

function wpc_product_image_height_callback() {
    $value = get_option('wpc_product_image_height', '150'); 
    echo '<input type="number" name="wpc_product_image_height" value="' . esc_attr($value) . '" class="wpc-input" /> px';
}

// Callbacks for product details visibility
function wpc_show_product_image_callback() {
    $checked = get_option('wpc_show_product_image', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_product_image" value="yes"' . checked($checked, true, false) . ' />';
}

function wpc_show_product_name_callback() {
    $checked = get_option('wpc_show_product_name', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_product_name" value="yes"' . checked($checked, true, false) . ' />';
}

function wpc_show_product_price_callback() {
    $checked = get_option('wpc_show_product_price', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_product_price" value="yes"' . checked($checked, true, false) . ' />';
}

// function wpc_show_product_sale_price_callback() {
//     $checked = get_option('wpc_show_product_sale_price', 'yes') === 'yes';
//     echo '<input type="checkbox" name="wpc_show_product_sale_price" value="yes"' . checked($checked, true, false) . ' />';
// }

function wpc_show_product_rating_callback() {
    $checked = get_option('wpc_show_product_rating', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_product_rating" value="yes"' . checked($checked, true, false) . ' />';
}

function wpc_show_product_stock_status_callback() {
    $checked = get_option('wpc_show_product_stock_status', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_product_stock_status" value="yes"' . checked($checked, true, false) . ' />';
}

function wpc_show_product_attribute_callback() {
    $checked = get_option('wpc_show_product_attribute', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_product_attribute" value="yes"' . checked($checked, true, false) . ' />';
}
?>
