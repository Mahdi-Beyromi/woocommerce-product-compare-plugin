<?php
/**
 * Plugin Name: Woocommerce Product Compare
 * Description: A custom product compare plugin for Woocommerce
 * Version: 1.0
 * Author: Mahdi Beyromi
 * Text Domain: woocommerce-product-compare
 * Requires at least: 5.0
 * Tested up to: 6.0
 * Requires PHP: 7.2
 * WC requires at least: 3.0
 * WC tested up to: 5.0
 */

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wpc_add_settings_link' );
function wpc_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=wpc-settings">Settings</a>';
    array_push( $links, $settings_link );
    return $links;
}

if ( !defined( 'ABSPATH' ) ) exit;

define( 'WPC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once WPC_PLUGIN_DIR . 'includes/hooks.php';
require_once WPC_PLUGIN_DIR . 'includes/helpers.php';
require_once WPC_PLUGIN_DIR . 'includes/compare-functions.php';
require_once WPC_PLUGIN_DIR . 'includes/activation.php';
require_once WPC_PLUGIN_DIR . 'public/compare-page.php';
register_activation_hook(__FILE__, 'wpc_create_compare_page');
// require_once WPC_PLUGIN_DIR . 'public/enqueue-scripts.php';

if ( is_admin() ) {
    require_once WPC_PLUGIN_DIR . 'admin/settings-page.php';
    require_once WPC_PLUGIN_DIR . 'admin/settings-handler.php';
}


function wpc_start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'wpc_start_session');
