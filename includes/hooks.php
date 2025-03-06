<?php

// Add admin menu
add_action('admin_menu', function() {
    add_menu_page(
        'Product Compare Settings',
        'Product Compare',
        'manage_options',
        'wpc-settings',
        'wpc_settings_page'
    );
});

// Register shortcode for compare page
add_shortcode('wpc_compare_page', 'wpc_render_compare_page');
