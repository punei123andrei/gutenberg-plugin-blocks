<?php
declare(strict_types=1);
namespace WrOOP;

class AjaxHandler {
    public function __construct() {
        add_action('wp_ajax_wr_create_post', [$this, 'wr_create_post']);
        add_action('wp_ajax_nopriv_wr_create_post', [$this, 'wr_create_post']);
    }

    public function wr_create_post() {
        if (!$this->verify_nonce()) {
            wp_send_json_error('Invalid security token.');
        }
        $form_data = $this->handle_post_data();
        $entry_data = $this->get_post_data($form_data);
        $results = $this->insert_post($entry_data);
        wp_send_json($results);
        wp_die();
    }

    private function verify_nonce() {
        $token = isset($_GET['token']) ? $_GET['token'] : '';
        return wp_verify_nonce($token, 'wr_token');
    }

    private function handle_post_data(array $form_fields): array {
        $form_data = isset($form_fields) ? $form_fields : '';
        parse_str($form_data, $field_value);

        $post_data = [];
        $post_data['job_title'] = isset($field_value['jobTitle']) ? sanitize_text_field($field_value['jobTitle']) : '';
        $post_data['first_name'] = isset($field_value['firstName']) ? sanitize_text_field($field_value['firstName']) : '';
        $post_data['last_name'] = isset($field_value['lastName']) ? sanitize_text_field($field_value['lastName']) : '';
        $post_data['entry_date'] = isset($field_value['entryDate']) ? sanitize_text_field($field_value['entryDate']) : '';
        
        return $post_data;
    }


    private function current_date(string $entry_date): string{
        $current_date = date("d-m-Y", strtotime($entry_date));
        return $current_date;
    }

    public function get_post_data(array $form_data): array{

        [ $job_title, $first_name, $last_name, $post_date ] = $form_data;

        $existing_post_args = ["post_type" => "wr-job-title", "posts_per_page" => 1, "s" => $job_title];
        $existing_post = get_posts( $existing_post_args );
    
        $existing_post_id = !empty($existing_post) ? $existing_post[0]->ID : 0;
        $meta_skills = $existing_post_id ? get_post_meta($existing_post_id, 'skills', true) : '';
        $skills_array = json_decode($meta_skills);

        $skills = implode(", ", $skills_array);
        $candidate = $first_name . ' ' . $last_name;
        $new_slug = $job_title . '-' . uniqid();

        return [
            'job_title'     => $job_title,
            'new_slug'      => $new_slug,
            'candidate'     => $candidate,
            'skills'        => $skills,
            'entry_date'    => $post_date
        ];
    }

    public function insert_post(
        string $post_type = 'wr-job-title',
        array $entry_data,
        ): array 
    {
        [ $job_title, $new_slug, $candidate, $skills, $entry_date ] = $entry_data;

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
        add_post_meta($post_id, 'skills', $skills);

        $results = [
            'data' => 'success',
            ...$entry_data
        ];
        return $results;
    }
}
