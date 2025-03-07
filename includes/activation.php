<?php

if ( !defined('ABSPATH') ) exit;

function wpc_create_compare_page() {
    $page_slug = 'wpc-compare';
    $page_title = 'Product Compare';

    $page_title = get_option('wpc_compare_page_title', $default_title);

    // Check if the page already exists
    $existing_page = get_page_by_path($page_slug);
    if ($existing_page) {
        return;
    }

    // Create the page
    $page_id = wp_insert_post([
        'post_title'   => $page_title,
        'post_name'    => $page_slug,
        'post_content' => '[wpc_compare_page]', // This will be replaced with actual rendering
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ]);

    if ($page_id && !is_wp_error($page_id)) {
        update_option('wpc_compare_page_id', $page_id);
    }
}

add_action('updated_option', 'wpc_update_compare_page_title', 10, 3);

function wpc_update_compare_page_title($option, $old_value, $new_value) {
    if ($option !== 'wpc_compare_page_title') {
        return;
    }

    $page_id = get_option('wpc_compare_page_id');
    if (!$page_id) {
        return;
    }

    wp_update_post([
        'ID'         => $page_id,
        'post_title' => $new_value
    ]);
}

