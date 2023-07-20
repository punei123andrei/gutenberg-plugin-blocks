<?php
/**
 * Plugin Name:       Wp Riders OOP
 * Plugin URI:        https://wpriders.com/
 * Description:       The refacto version of WP-Riders.
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
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


define('WR_OPP_PLUGIN_DIR', plugin_dir_path(__FILE__));
$blocks = glob(WR_OPP_PLUGIN_DIR . 'blocks/*.php');

foreach($blocks as $block){
  include_once $block;
};

use WrOOP\Setup\Setup;
new Setup();

