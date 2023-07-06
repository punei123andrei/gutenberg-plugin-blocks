<?php
function wr_add_job_titles(){
    $wr_entries = [
        'Andrei Punei'  => [
            'Junior Tester' => ['details', 'browser-stack']
        ],
        'Mircea Radu'   => [
            'Senior Designer' => ['photoshop', 'ilustrator']
        ],
        'Florin Panciu' => [
            'Business Line Manager' => ['comunication', 'service delivery', 'development']
        ],
        'Popescu Vlad'  => [
            'SEO Specialist' => ['ppt campaigns', 'comunication']
        ],
        'Simona Vlahuta'=> [
            'Director' => ['basic', 'management skills', 'PR']
        ]
    ];
    
    foreach($job_titles as $job_title => $skills){
        $new_post = array(
            'post_type'     => 'wr-job-title',
            'post_title'    => __($job_title, 'wp-riders'),
            'post_status'   => 'publish'
          );
          
          $resulted_skills = array_map(function ($item) {
            return str_replace(' ', '-', $item);
          }, $skills);

      $post_id = wp_insert_post($new_post);
      update_post_meta($post_id, 'skills', json_encode($resulted_skills));
    }
}