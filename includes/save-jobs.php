<?php

function save_custom_wr_metabox_values($post_id) {
    if (isset($_POST['skills'])) {
        $selected_values = $_POST['skills'];
        $sanitized_values = array_map('sanitize_text_field', $selected_values);
        update_post_meta($post_id, 'skills', json_encode($sanitized_values));
    }
    if (isset($_POST['candidate'])) {
        $selected_name = sanitize_text_field($_POST['candidate']);
        update_post_meta($post_id, 'candidate', $selected_name );
    }
  }