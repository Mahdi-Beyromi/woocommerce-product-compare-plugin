<?php
// Add a settings page for the plugin
add_action( 'admin_menu', 'wpc_add_settings_page' );

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
}

// Display settings page
function wpc_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>Product Compare Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'wpc_options_group' );
            do_settings_sections( 'wpc-settings' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Compare Page Title</th>
                    <td><input type="text" name="wpc_compare_page_title" value="<?php echo esc_attr( get_option( 'wpc_compare_page_title', 'Product Comparison' ) ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
