<?php 

function wr_application_form(){
  $wr_query_args = [
    'post_type' => 'wr-job-title',
    'posts_per_page' => -1
  ];

    $wr_posts = get_posts($wr_query_args);
    $post_titles = [];
    foreach ($wr_posts as $post) {
      $post_titles[] = $post->post_title;
    }
    $unique_titles = array_unique($post_titles);
    ob_start();
    ?>
    <form class="wr-form" id="wr-job-application">
            <label for="jobTitle"><?php _e('Job Title', 'wp-riders')?></label>
            <select name="jobTitle" id="jobTitle">
              <?php
              foreach ($unique_titles as $title){
                ?>
                  <option value="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></option>
                <?php
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