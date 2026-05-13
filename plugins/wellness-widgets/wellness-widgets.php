<?php
/**
 * Plugin Name:  Wellness Widgets
 * Plugin URI:   https://github.com/rongner/WordPressDemo
 * Description:  A collection of reusable sidebar widgets: Featured Product, Promo Banner, Testimonial, and Recent Posts with Thumbnail.
 * Version:      1.0.0
 * Author:       Michael Rongner
 * License:      GPL-2.0-or-later
 * Text Domain:  wellness-widgets
 */

defined( 'ABSPATH' ) || exit;

define( 'WW_DIR', plugin_dir_path( __FILE__ ) );
define( 'WW_URL', plugin_dir_url( __FILE__ ) );

require_once WW_DIR . 'widgets/class-featured-product-widget.php';
require_once WW_DIR . 'widgets/class-promo-banner-widget.php';
require_once WW_DIR . 'widgets/class-testimonial-widget.php';
require_once WW_DIR . 'widgets/class-recent-posts-thumb-widget.php';

function ww_register_widgets() {
	register_widget( 'WW_Featured_Product_Widget' );
	register_widget( 'WW_Promo_Banner_Widget' );
	register_widget( 'WW_Testimonial_Widget' );
	register_widget( 'WW_Recent_Posts_Thumb_Widget' );
}
add_action( 'widgets_init', 'ww_register_widgets' );

function ww_enqueue_styles() {
	wp_enqueue_style(
		'wellness-widgets',
		WW_URL . 'assets/css/widgets.css',
		[],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'ww_enqueue_styles' );
