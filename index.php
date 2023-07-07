<?php
/**
 * Plugin Name:       Wp Riders Table test
 * Plugin URI:        https://wpriders.com/
 * Description:       A test plugin for creating a table.
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Author:            Andrei Punei
 * Text Domain:       wp-riders
 * Domain Path:       /languages
 */
    
 if(!function_exists('add_action')) {
  exit;
}

// Setup
define('WR_PLUGIN_DIR', plugin_dir_path(__FILE__));
add_action('init', 'wr_create_job_title_post_type', 5);
register_activation_hook(__FILE__, 'wr_add_job_titles', 10);
register_deactivation_hook(__FILE__, 'wr_delete_job_titles', 10);

// Includes
$rootFiles = glob(WR_PLUGIN_DIR . 'includes/*.php');
$subdirectoryFiles = glob(WR_PLUGIN_DIR . 'includes/**/*.php');
$allFiles = array_merge($rootFiles, $subdirectoryFiles);

foreach($allFiles as $filename){
  include_once $filename;
};

// Actions
add_action('init', 'wr_register_blocks', 20);
add_action( 'add_meta_boxes', 'wr_add_custom_box' );
add_action('admin_enqueue_scripts', 'wr_job_titles_admin_scripts');
add_action('wp_enqueue_scripts', 'wr_frontend_scripts');
add_action('save_post', 'save_custom_wr_metabox_values'); 


// Filters
add_filter('add_meta_boxes', 'hide_meta_boxes');


// Ajax actions
add_action('wp_ajax_wr_insert_post', 'wr_insert_post');
add_action('wp_ajax_nopriv_wr_insert_post', 'wr_insert_post');