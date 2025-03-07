<?php
/**
 * Plugin Name: Woocommerce Product Compare
 * Description: A custom product compare plugin for Woocommerce
 * Version: 1.0
 * Author: Mahdi Beyromi
 * Text Domain: woocommerce-product-compare
 */

if ( !defined( 'ABSPATH' ) ) exit;

define( 'WPC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once WPC_PLUGIN_DIR . 'includes/hooks.php';
require_once WPC_PLUGIN_DIR . 'includes/helpers.php';
require_once WPC_PLUGIN_DIR . 'includes/compare-functions.php';
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
