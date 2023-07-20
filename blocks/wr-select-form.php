<?php 

function wr_select_form($atts) {
  $font_weight = esc_attr($atts['fontWeight']);
  $style_attr = "font-weight:{$font_weight}";
  $wr_query_args = [
    'post_type' => 'wr-job-title',
    'posts_per_page' => -1
  ];
  $wr_query = new WP_Query($wr_query_args);
    ob_start();
    ?>
    <form class="wr-form wr-select-form" id="wr-sort">
          <label style="<?php echo $style_attr; ?>" for="sortTable"><?php _e('Select a skill', 'wp-riders') ?></label>
          <select name="sortTable" id="sortTable">
            <?php
            $all_skills = []; 
            if ($wr_query->have_posts()) {
              while ($wr_query->have_posts()) {
                  $wr_query->the_post();
                  $wr_skills = get_post_meta(get_the_ID(), 'skills', true);
                  $list_skills = json_decode($wr_skills);
                  if (is_array($list_skills)) {
                    $all_skills = array_merge($all_skills, $list_skills);
                }
              }
              }
              wp_reset_postdata();
              $skills = array_unique($all_skills);
              if (!empty($skills)) {
                foreach ($skills as $skill) {
                  ?>
                  <option value="<?php echo esc_attr($skill); ?>"><?php echo esc_html($skill); ?></option>
                  <?php 
              }
              }
            ?>
          </select>
        </form>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}