<?php

function wpc_render_compare_page() {
    ob_start();
    ?>
    <div class="wpc-compare-container">
        <h2>Product Compare Page</h2>
        <!-- Table or content will be added here later -->
    </div>
    <?php
    return ob_get_clean();
}
