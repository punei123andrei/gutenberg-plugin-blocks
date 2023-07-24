<?php 
// declare(strict_types=1);
namespace WrOOP;

class AjaxHandler {
    

    public function __construct(){
        add_action('wp_ajax_wr_insert_post', [$this, 'wr_insert_post']);
        add_action('wp_ajax_nopriv_wr_insert_post', [$this, 'wr_insert_post']);
    }

    public function wr_insert_post() {
        $token = isset($_GET['token']) ? $_GET['token'] : '';
        if (!wp_verify_nonce($token, 'wr_token')) {
            wp_send_json_error('Invalid security token.');
            wp_die();
        }
        $form_data = $this->handle_post_data($_GET['formData']);
        $post_data = $this->get_post_data($form_data);
        $results = $this->insert_post('wr-job-title', $post_data);
        wp_send_json($results);
        wp_die();
    }

    private function current_date(string $entry_date): string{
        $current_date = date("d-m-Y", strtotime($entry_date));
        return $current_date;
    }

    private function handle_post_data(string $form_fields): array {
        $form_data = isset($form_fields) ? $form_fields : '';
        parse_str($form_data, $field_value);
        $post_data = [];
        $post_data[] = isset($field_value['jobTitle']) ? sanitize_text_field($field_value['jobTitle']) : '';
        $post_data[] = isset($field_value['firstName']) ? sanitize_text_field($field_value['firstName']) : '';
        $post_data[] = isset($field_value['lastName']) ? sanitize_text_field($field_value['lastName']) : '';
        $post_data[] = isset($field_value['entryDate']) ? sanitize_text_field($field_value['entryDate']) : '';
        return $post_data;
    }

    private function get_post_data( array $form_data): array {
        [ $job_title ,$first_name, $last_name, $entry_date ] = $form_data;
        $existing_post_args = ["post_type" => "wr-job-title", "posts_per_page" => 1, "s" => $job_title];
        $existing_post = get_posts( $existing_post_args );
        $existing_post_id = !empty($existing_post) ? $existing_post[0]->ID : 0;
        $meta_skills = $existing_post_id ? get_post_meta($existing_post_id, 'skills', true) : '';
        $metas[] = json_decode($meta_skills);
        $metas[] = $first_name . ' ' . $last_name;
        $metas[] = $job_title . '-' . uniqid();
        $metas[] = $this->current_date($entry_date);
        $prepared_data = array_merge($form_data, $metas);
        return $prepared_data;
    }

    public function insert_post(
        string $post_type = 'wr-job-title',
        array $entry_data,
        )
    {
         [ $job_title, $first_name, $last_name, $date, $skills, $candidate, $new_slug, $entry_date ] = $entry_data;
        $new_post = [
            'post_type' => $post_type,
            'post_title' => $job_title,
            'post_status' => 'publish',
            'post_name' => $new_slug
        ];
        $post_id = wp_insert_post($new_post);
        if (is_wp_error($post_id)) {
            wp_send_json_error('Failed to insert post.');
            wp_die();
        }
        add_post_meta($post_id, 'candidate', $candidate);
        add_post_meta($post_id, 'wr_date', $entry_date);
        add_post_meta($post_id, 'skills', json_encode($skills));
        $results = [
            'success',
            ...$entry_data
        ];
        return $results;
    }
}