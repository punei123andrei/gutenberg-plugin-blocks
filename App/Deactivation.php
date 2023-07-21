<?php 
declare(strict_types=1);
namespace WrOOP;

class Deactivation {


    public function __construct(){
        $plugin_file = dirname(dirname(__FILE__)) . '/index.php';
        register_deactivation_hook($plugin_file, [$this, 'wr_delete_job_titles']);
    }

    public function wr_delete_job_titles() {
        $args = array(
            'post_type' => 'wr-job-title',
            'posts_per_page' => -1,
        );
      
        $job_titles = get_posts($args);
      
        foreach ($job_titles as $job_title) {
            wp_delete_post($job_title->ID, true);
        }
    }
}

