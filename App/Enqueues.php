<?php 
declare(strict_types=1);
namespace WrOOP;

class Enqueues {
    public function __construct(){
        add_action('admin_enqueue_scripts', [$this, 'wr_oop_enqueue_admin_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'wr_oop_frontend_scripts']);
    }

    public function wr_oop_enqueue_admin_scripts() {
        $current_screen = get_current_screen();
        if ($current_screen->post_type === 'wr-job-title') {
            wp_enqueue_style('wr-oop-select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
            wp_enqueue_script('wr-oop-select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.5.0', true);
            wp_enqueue_script('wr-oop-admin-script', plugins_url('../assets/admin.js', __FILE__), array('jquery'), microtime(), true);
        }
      }

      function wr_oop_frontend_scripts(){
        wp_enqueue_script('wr-frontend-script', plugins_url('../assets/frontend.js', __FILE__), array('jquery'), '1.0', true);
        $translations = [
            'formSubmissionSuccess' => __('Job Application submited!', 'wp_riders'),
            'formSubmissionError' => __('Failed to submit the form. Please try again.', 'wp_riders'),
            'requestProcessingError' => __('An error occurred while processing your request. Please try again.', 'wp_riders')
        ];
            
        wp_localize_script(
            'wr-frontend-script',
            'wr_job_obj',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'token' => wp_create_nonce('wr_token'),
                'translations' => $translations
            ]
        );
        wp_enqueue_script('wr-frontend-script');
    }
}