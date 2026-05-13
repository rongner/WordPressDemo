<?php
/**
 * Plugin Name:  Portfolio CPT
 * Plugin URI:   https://github.com/rongner/WordPressDemo
 * Description:  Registers a Portfolio custom post type with Project Type taxonomy, meta fields, and custom admin columns.
 * Version:      1.0.0
 * Author:       Michael Rongner
 * License:      GPL-2.0-or-later
 * Text Domain:  portfolio-cpt
 */

defined( 'ABSPATH' ) || exit;

define( 'PCPT_DIR', plugin_dir_path( __FILE__ ) );
define( 'PCPT_URL', plugin_dir_url( __FILE__ ) );

require_once PCPT_DIR . 'includes/class-portfolio-cpt.php';
require_once PCPT_DIR . 'includes/class-portfolio-meta.php';
require_once PCPT_DIR . 'includes/class-portfolio-columns.php';

( new Portfolio_CPT() )->init();
( new Portfolio_Meta() )->init();
( new Portfolio_Columns() )->init();
