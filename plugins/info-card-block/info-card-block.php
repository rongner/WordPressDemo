<?php
/**
 * Plugin Name:       Info Card Block
 * Description:       A card with an image, heading, body text, and a CTA button.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      8.1
 * Author:            Michael Rongner
 * License:           GPL-2.0-or-later
 * Text Domain:       info-card-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function info_card_block_init() {
	register_block_type( __DIR__ );
}
add_action( 'init', 'info_card_block_init' );
