<?php
function wr_add_job_titles(){
    $job_titles = [
        'Junior Tester'         => ['details', 'browser-stack'],
        'Senior Designer'       => ['photoshop', 'ilustrator'],
        'Business Line Manager' => ['comunication', 'service delivery', 'development'],
        'SEO Specialist'        => ['ppt campaigns', 'comunication'],
        'Director'              => ['basic', 'management skills', 'PR']
    ];
    foreach($job_titles as $job_title => $skills){
        $new_post = array(
            'post_type'     => 'wr-job-title',
            'post_title'    => __($job_title, 'wp-riders'),
            'post_status'   => 'publish'
          );
      $post_id = wp_insert_post($new_post);
      update_post_meta($post_id, 'skills', json_encode($skills));
    }
}