<?php 

function wr_job_table($atts) {
    $font_size = esc_attr($atts['fontSize']);
    $text_color = esc_attr($atts['textColor']);
    $bg_even_row = esc_attr($atts['bgEvenRow']);
    $style_attr = "font-size:{$font_size}px;background:{$bg_even_row};color:{$text_color};";
    $wr_query_args = [
      'post_type' => 'wr-job-title',
      'posts_per_page' => -1
    ];
    $wr_query = new WP_Query($wr_query_args);
    ob_start();
    ?>
        <div class="tableBlock">
          <table class="wr-table-sort">
          <?php 
            if ($wr_query->have_posts()) {
              $counter = 0;
            while ($wr_query->have_posts()) {
                $wr_query->the_post();
                $wr_skills = get_post_meta(get_the_ID(), 'skills', true);
                $wr_name = get_post_meta(get_the_ID(), 'candidate', true);
                $name_parts = explode(" ", $wr_name);
                if (count($name_parts) >= 2) {
                    $name = $name_parts[0];
                    $lastname = $name_parts[1];
                } else {
                    $name = $wr_name;
                    $lastname = '';
                }

                $array_skills = json_decode($wr_skills);
                
                $list_skills = implode(' ', $array_skills);
                $is_even = $counter % 2 === 0;
                ?>
                <tr class="rider-row" data-sort="<?php echo esc_attr($list_skills); ?>" style="<?php echo $is_even ? $style_attr : ''; ?>">
                  <td class="post-title"><p><?php echo get_the_title(); ?></p></td>
                  <td class="first-name"><p><?php echo esc_html($name); ?></p></td>
                  <td class="last-name"><p><?php echo esc_html($lastname); ?></p></td>
                  <td class="skills"><p><?php echo esc_html($list_skills); ?></p></td>
                </tr>
                <?php
                $counter++;
            }
            } else {
                echo 'No job titles found.';
            }
            wp_reset_postdata();
        ?>
          </table>
      </div>
    <?php 
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}