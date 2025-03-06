<?php

function wpc_settings_page() {
    ?>
    <div class="wrap">
        <h2>Product Compare Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('wpc_settings_group');
            do_settings_sections('wpc-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
