<?php

add_action('admin_init', 'wpc_register_settings');

function wpc_register_settings() {
    register_setting('wpc_options_group', 'wpc_compare_page_title');
    register_setting('wpc_options_group', 'wpc_show_add_to_cart_button');

    add_settings_section('wpc_main_section', '', null, 'wpc-settings');

    add_settings_field(
        'wpc_compare_page_title',
        'Compare Page Title',
        'wpc_compare_page_title_callback',
        'wpc-settings',
        'wpc_main_section'
    );

    add_settings_field(
        'wpc_show_add_to_cart_button',
        'Show Add to Cart Button in Compare Page',
        'wpc_show_add_to_cart_button_callback',
        'wpc-settings',
        'wpc_main_section'
    );
}

function wpc_compare_page_title_callback() {
    $value = get_option('wpc_compare_page_title', 'Product Comparison');
    echo '<input type="text" name="wpc_compare_page_title" value="' . esc_attr($value) . '" />';
}

function wpc_show_add_to_cart_button_callback() {
    $checked = get_option('wpc_show_add_to_cart_button', 'yes') === 'yes';
    echo '<input type="checkbox" name="wpc_show_add_to_cart_button" value="yes"' . checked($checked, true, false) . ' />';
}
