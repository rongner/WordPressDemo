<?php
/**
 * Plugin Name:  Wellness REST API
 * Plugin URI:   https://github.com/rongner/WordPressDemo
 * Description:  Custom REST API endpoints under /wp-json/wellness/v1/ for portfolio projects and WooCommerce products.
 * Version:      1.0.0
 * Author:       Michael Rongner
 * License:      GPL-2.0-or-later
 * Text Domain:  wellness-api
 */

defined( 'ABSPATH' ) || exit;

define( 'WAPI_DIR', plugin_dir_path( __FILE__ ) );

require_once WAPI_DIR . 'endpoints/class-portfolio-endpoint.php';
require_once WAPI_DIR . 'endpoints/class-products-endpoint.php';

add_action( 'rest_api_init', function () {
	( new Wellness_Portfolio_Endpoint() )->register_routes();
	( new Wellness_Products_Endpoint() )->register_routes();
} );
