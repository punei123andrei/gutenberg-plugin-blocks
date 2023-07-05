<?php 
function wr_delete_job_titles() {
    $args = array(
        'post_type' => 'wr-job-title',
        'posts_per_page' => -1,
    );
  
    $job_titles = get_posts($args);
  
    foreach ($job_titles as $job_title) {
        wp_delete_post($job_title->ID, true);
    }
}