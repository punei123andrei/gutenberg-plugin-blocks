<?php 

function wr_application_form(){
    $wr_query_args = [
      'post_type' => 'wr-job-title',
      'posts_per_page' => -1
    ];
    $wr_query = new WP_Query($wr_query_args);
    ob_start();
    ?>
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