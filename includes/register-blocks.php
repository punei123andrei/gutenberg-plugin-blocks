<?php

function wr_register_blocks() {
  $blocks = [
      [ 'name' => 'job-application' ],
      [ 'name' => 'wr-select-form', 'options' => [
        'render_callback' => 'wr_select_form'
      ]],
      [ 'name' => 'wr-job-table', 'options' => [
        'render_callback' => 'wr_job_table'
      ]],
      [ 'name' => 'wr-application-form', 'options' => [
        'render_callback' => 'wr_application_form'
      ]]
    ];

  foreach($blocks as $block) {
    register_block_type(
      WR_PLUGIN_DIR . 'build/blocks/' . $block['name'],
      isset($block['options']) ? $block['options'] : []
    );
  }
}