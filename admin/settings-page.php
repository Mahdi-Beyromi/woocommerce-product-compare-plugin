<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'wpc_add_settings_page');

function wpc_add_settings_page() {
    add_menu_page(
        'WooCommerce Product Compare',
        'Product Compare',
        'manage_options',
        'wpc-settings',
        'wpc_settings_page_html',
        'dashicons-randomize',
        30
    );

    add_submenu_page(
        'wpc-settings',
        'Site Attribute',
        'Site Attribute',
        'manage_options',
        'wpc-attribute-list',
        'wpc_attribute_list_page'
    );
}

function wpc_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>Product Compare Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wpc_options_group');
            do_settings_sections('wpc-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function wpc_attribute_list_page() {
    include_once plugin_dir_path(__FILE__) . 'attribute-list.php';
}