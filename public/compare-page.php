<?php
// Include the header and other necessary files
get_header();

// Ensure the comparison data is available, add necessary checks
if ( isset( $_SESSION['comparison_products'] ) && count( $_SESSION['comparison_products'] ) == 2 ) :
    $product1 = wc_get_product( $_SESSION['comparison_products'][0] );
    $product2 = wc_get_product( $_SESSION['comparison_products'][1] );
    ?>
    <div class="product-compare-table">
        <h1><?php echo get_option( 'wpc_compare_page_title', 'Product Comparison' ); ?></h1>
        <table>
            <tr>
                <td>Product 1</td>
                <td>Product 2</td>
            </tr>
            <tr>
                <td><?php echo $product1->get_name(); ?></td>
                <td><?php echo $product2->get_name(); ?></td>
            </tr>
            <!-- Add more product attributes here -->
            <tr>
                <td><?php echo $product1->get_price_html(); ?></td>
                <td><?php echo $product2->get_price_html(); ?></td>
            </tr>
            <!-- Add additional rows for features -->
        </table>
    </div>
<?php
else :
    echo '<p>No products to compare.</p>';
endif;

get_footer();
?>
