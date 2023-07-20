<?php 
declare(strict_types=1);
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
    
        $form_data = isset($_GET['formData']) ? $_GET['formData'] : '';
        parse_str($form_data, $form_fields);
    
        $job_title = isset($form_fields['jobTitle']) ? sanitize_text_field($form_fields['jobTitle']) : '';
        $first_name = isset($form_fields['firstName']) ? sanitize_text_field($form_fields['firstName']) : '';
        $last_name = isset($form_fields['lastName']) ? sanitize_text_field($form_fields['lastName']) : '';
        $entry_date = isset($form_fields['entryDate']) ? sanitize_text_field($form_fields['entryDate']) : '';
    
        $current = date("d-m-Y", strtotime($entry_date));
    
        $existing_post_args = ["post_type" => "wr-job-title", "s" => $job_title];
        $existing_post = get_posts( $existing_post_args );
    
        $existing_post_id = !empty($existing_post) ? $existing_post[0]->ID : 0;
        $post_meta = $existing_post_id ? get_post_meta($existing_post_id, 'skills', true) : '';
    
        $skills_array = json_decode($post_meta);
        $skills = implode(", ", $skills_array);
    
        $candidate = $first_name . ' ' . $last_name;
        $new_slug = $job_title . '-' . uniqid();
        $new_post = [
            'post_type' => 'wr-job-title',
            'post_title' => $job_title,
            'post_status' => 'publish',
            'post_name' => $new_slug
        ];
    
        $new_post['post_title'] = $job_title;
    
        $post_id = wp_insert_post($new_post);
    
        if (is_wp_error($post_id)) {
            wp_send_json_error('Failed to insert post.');
            wp_die();
        }
    
        add_post_meta($post_id, 'candidate', $candidate);
        add_post_meta($post_id, 'wr_date', $entry_date);
    
        // Ads the existing skills based on the previous post
        if(!empty($post_meta)){
            add_post_meta($post_id, 'skills', $post_meta);
        }
        $results = [
            'data'       => 'success',
            'title'      => $job_title,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'skills'     => $skills,
            'entry_date' => $current
        ];
        wp_send_json($results);
        wp_die();
    }
}