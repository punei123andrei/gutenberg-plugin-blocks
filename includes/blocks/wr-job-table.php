<?php 

function wr_job_table($atts) {
    $font_size = esc_attr($atts['fontSize']);
    $bd_color = esc_attr($atts['borderBottomColor']);
    $style_attr = "font-size:{$font_size}px;border-bottom: 1px solid {$bd_color}; width: 50%;";
    $wr_query_args = [
      'post_type' => 'wr-job-title',
      'posts_per_page' => -1
    ];
    $wr_query = new WP_Query($wr_query_args);
    ob_start();
    ?>
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
    <?php 
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}