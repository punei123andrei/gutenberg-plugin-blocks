<?php 
namespace WrOOP;

class Activation {

    public function __construct(){
        $plugin_file = dirname(dirname(__FILE__)) . '/index.php';
        register_activation_hook($plugin_file, [$this, 'wr_add_job_titles']);
        add_action( 'add_meta_boxes', [$this, 'wr_add_custom_box']);
    }

    public function wr_add_job_titles(){
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
            $new_post = [
                'post_type'     => 'wr-job-title',
                'post_title'    => $job_title,
                'post_status'   => 'publish'
            ];
              $post_id = wp_insert_post($new_post);
              foreach($candidates as $candidate => $skills){
                $resulted_skills = array_map(function ($item) {
                    return str_replace(' ', '-', $item);
                  }, $skills);
                  $current_date = date("d-m-Y");
                  update_post_meta($post_id, 'candidate', $candidate);
                  update_post_meta($post_id, 'skills', json_encode($resulted_skills));
                  update_post_meta($post_id, 'wr_date', $current_date);
              }
        }
    }

    public function wr_add_custom_box($post_type) {
        $screens = [ 'job-title', 'wr-job-title' ];
        if (in_array($post_type, $screens)) {
            add_meta_box(
                'wr-job-title',                
                'Skills',      
                [$this, 'wr_skills_custom_box_html'],  
                $post_type                            
            );
        }
    }

    public function wr_skills_custom_box_html( $post ) {
        $candidate_name = get_post_meta($post->ID, 'candidate', true);
        $skills = json_decode(get_post_meta($post->ID, 'skills', true));
        $all_skills =  $this->wr_post_meta();

       
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

    public function wr_post_meta(){
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

}