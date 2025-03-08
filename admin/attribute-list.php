<?php

if (!defined('ABSPATH')) {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wpc_save_attributes'])) {
    $selected_attributes = isset($_POST['wpc_selected_attributes']) ? array_map('sanitize_text_field', $_POST['wpc_selected_attributes']) : [];

    $selected_attributes = array_map(function ($attr) {
        return 'pa_' . $attr;
    }, $selected_attributes);

    if (empty($selected_attributes)) {
        delete_option('wpc_selected_attributes');
    } else {
        update_option('wpc_selected_attributes', $selected_attributes);
    }
}

$saved_attributes = get_option('wpc_selected_attributes', []);

$all_attributes = wc_get_attribute_taxonomies();

?>
<div class="wrap">
    <h1>Attribute List </h1>
    <form method="post">
        <ul class="attribute-list">
            <?php
            foreach ($all_attributes as $attribute) {
                $attr_slug = esc_attr($attribute->attribute_name);
                $attr_with_prefix = 'pa_' . $attr_slug;
                $checked = in_array($attr_with_prefix, $saved_attributes) ? 'checked' : '';

                echo '<li class="attribute-item">';
                echo '<label>';
                echo '<input type="checkbox" name="wpc_selected_attributes[]" value="' . $attr_slug . '" ' . $checked . '> ';
                echo esc_html($attribute->attribute_label);
                echo '</label>';
                echo '</li>';
            }
            ?>
        </ul>
        <button type="submit" name="wpc_save_attributes" class="button button-primary">Save</button>
    </form>
</div>
