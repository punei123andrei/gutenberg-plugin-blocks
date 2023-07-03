<?php 

function wr_job_titles_admin_scripts(){
    $current_screen = get_current_screen();
    if ($current_screen->post_type === 'wr-job-title') {
        wp_enqueue_style('wr-select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
        wp_enqueue_script('wr-select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.5.0', true);
        wp_enqueue_script('wr-job-title-script', plugins_url('../assets/admin.js', __FILE__), array('jquery'), '1.0', true);
	    
        }
}

function wr_frontend_scripts(){
    wp_enqueue_script('wr-frontend-script', plugins_url('../assets/frontend.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script(
        'wr-frontend-script',
        'wr_job_obj',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'token' => wp_create_nonce('wr_token')
        ]
    );
    wp_enqueue_script('wr-frontend-script');
}