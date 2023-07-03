<?php

function wr_register_blocks() {
  $blocks = [
    [ 'name' => 'job-form', 'options' => [
      'render_callback' => 'wr_job_form'
      ]]
    ];

  foreach($blocks as $block) {
    register_block_type(
      WR_PLUGIN_DIR . 'build/blocks/' . $block['name'],
      isset($block['options']) ? $block['options'] : []
    );
  }
}