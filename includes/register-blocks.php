<?php

function wr_register_blocks() {
  $blocks = [
    [ 'name' => 'popular-recipes', 'options' => [
      'render_callback' => 'wr_table_view'
    ]]
  ];

  foreach($blocks as $block) {
    register_block_type(
      WR_PLUGIN_DIR . 'build/blocks/' . $block['name'],
      isset($block['options']) ? $block['options'] : []
    );
  }
}