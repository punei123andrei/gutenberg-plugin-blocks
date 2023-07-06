<?php

function wr_add_custom_box() {
    $screens = [ 'job-title', 'wr-job-title' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wr-job-title',                
            'Skills',      
            'wr_skills_custom_box_html',  
            $screen                            
        );
    }
}

function wr_skills_custom_box_html( $post ) {
    $candidate_name = get_post_meta($post->ID, 'candidate', true);
    $skills = json_decode(get_post_meta($post->ID, 'skills', true));
    $all_skills =  wr_post_meta();
    ?>
    <div style="margin-bottom: 20px;">
        <label for="candidate"><?php _e('Candidate', 'wp_riders'); ?></label>
        <input name="candidate" id="candidate" value="<?php echo esc_attr($candidate_name); ?>">
    </div>

     <select class="wr-skills full-width-select2" name="skills[]" multiple="multiple" style="width: 100%">
     <?php
     foreach($all_skills as $skill){
        $option_value = str_replace(' ', '-', $skill);
        ?>
        <option value="<?php echo esc_attr($option_value); ?>" <?php echo in_array($skill, $skills) ? 'selected' : ''; ?> ><?php echo esc_html($skill); ?></option>
        <?php 
     }
     ?>
    </select>
    <?php
}

function wr_post_meta(){
    $args = [
        'post_type' => 'wr-job-title',
        'posts_per_page' => -1,
    ];
    $posts = get_posts($args);
    $wr_job_skills = [];
    if ($posts) {
        foreach ($posts as $post) {
            $post_meta = json_decode(get_post_meta($post->ID, 'skills', true));
            foreach($post_meta as $meta){
                array_push($wr_job_skills, $meta);
            }
        }
    }
    $wr_job_skills = array_unique($wr_job_skills);
    return $wr_job_skills;
}


