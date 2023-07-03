<?php 

function wr_table_view($atts){
    $font_size = esc_attr($atts['fontSize']);
    $bd_color = esc_attr($atts['borderBottomColor']);
    $style_attr = "font-size:{$font_size};border-bottom: 1px solid {$bd_color}; width: 50%;";
    $wr_query_args = [
      'post_type' => 'wr-job-title',
      'posts_per_page' => -1
    ];
    $wr_query = new WP_Query($wr_query_args);
    ob_start();
    ?>
      <form class="wr-form wr-select-form" id="wr-sort">
          <label for="sortTable"><?php _e('Select a skill', 'wp-riders') ?></label>
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

      <div class="tableBlock">
        <?php 
          if ($wr_query->have_posts()) {
            while ($wr_query->have_posts()) {
                $wr_query->the_post();
                $wr_skills = get_post_meta(get_the_ID(), 'skills', true);
                $array_skills = json_decode($wr_skills);
                $list_skills = implode(' ', $array_skills);
                ?>
                <div class="container-flex x-auto" data-sort="<?php echo esc_attr($list_skills); ?>">
                  <p style="<?php echo $style_attr; ?>"><?php echo get_the_title(); ?></p>
                  <p style="<?php echo $style_attr; ?>"><?php echo esc_html($list_skills); ?></p>
                </div>
                <?php
            }
            } else {
                echo 'No job titles found.';
            }
      wp_reset_postdata();
        ?>
      </div>
          <form class="wr-form" id="wr-job-application">
            <label for="jobTitle"><?php _e('Job Title', 'wp-riders')?></label>
            <select name="jobTitle" id="jobTitle">
              <?php
              if (!empty($skills)) {
                foreach ($skills as $skill) {
                  ?>
                  <option value="<?php echo esc_attr($skill); ?>"><?php echo esc_html($skill); ?></option>
                  <?php 
              }
              }
              ?>
            </select>
            <label for="firstName"><?php _e('First Name', 'wp-riders') ?></label>
            <input type="text" name="firstName" id="firstName" />
            <label for="lastName"><?php _e('Last Name', 'wp-riders') ?></label>
            <input type="text" name="lastName" id="lastName" />
            <label for="entryDate"><?php _e('Entry Date', 'wp-riders') ?></label>
            <input type="date" name="entryDate" id="entryDate" />
            <button type="submit"><?php _e('Submit', 'wp-riders') ?></button>
        </form>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}