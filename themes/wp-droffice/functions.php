<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_droffice_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' )
	);
}
add_action( 'after_setup_theme', 'wp_droffice_setup' );

function wp_droffice_scripts() {
	wp_enqueue_style(
		'wp-droffice-style',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'wp_droffice_scripts' );
