<?php
function wr_add_job_titles(){
    $wr_entries = [
        'Junior Tester' => [
            'Andrei Punei' => ['details', 'browser-stack']
        ],
        'Senior Designer'   => [
            'Mircea Radu' => ['photoshop', 'ilustrator']
        ],
        'Business Line Manager' => [
            'Florin Panciu' => ['comunication', 'service delivery', 'development']
        ],
        'SEO Specialist' => [
             'Popescu Vlad' => ['ppt campaigns', 'comunication']
        ],
        'Director' => [
            'Simona Vlahuta' => ['basic', 'management skills', 'PR']
        ]
    ];
    foreach($wr_entries as $job_title => $candidates){
        $new_post = array(
            'post_type'     => 'wr-job-title',
            'post_title'    => __($job_title, 'wp-riders'),
            'post_status'   => 'publish'
          );
          $post_id = wp_insert_post($new_post);
          foreach($candidates as $candidate => $skills){
            $resulted_skills = array_map(function ($item) {
                return str_replace(' ', '-', $item);
              }, $skills);
              
            // Tags to be configured at the end
            //   array_map(function($skill){
            //     wp_set_post_tags($post_id, 'jumir', true);
            //   }, $resulted_skills);

              update_post_meta($post_id, 'candidate', $candidate);
              update_post_meta($post_id, 'skills', json_encode($resulted_skills));
          }
    }
}