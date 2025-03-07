<?php

function wpc_enqueue_scripts() {
    wp_enqueue_style(
        'wpc-compare-css',
        WPC_PLUGIN_URL . 'assets/style.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'wpc-compare-js',
        WPC_PLUGIN_URL . 'assets/compare.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_localize_script('wpc-compare-js', 'woocommerce_compare', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wpc_compare_nonce'),
        'compare_page_url' => home_url('/wpc-compare/')
    ));
}
