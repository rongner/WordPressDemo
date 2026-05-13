<?php
defined( 'ABSPATH' ) || exit;

// ── Theme setup ───────────────────────────────────────────────────────────────

function wpw_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// ── WooCommerce ───────────────────────────────────────────────────────────
	add_theme_support( 'woocommerce', [
		'thumbnail_image_width' => 360,
		'single_image_width'    => 640,
		'product_grid'          => [
			'default_rows'    => 3,
			'min_rows'        => 1,
			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 4,
		],
	] );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'wp-wellness' ),
		'footer'  => __( 'Footer Menu',  'wp-wellness' ),
	] );
}
add_action( 'after_setup_theme', 'wpw_setup' );

// ── Scripts & styles ──────────────────────────────────────────────────────────

function wpw_enqueue() {
	wp_enqueue_style(
		'wp-wellness-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500&display=swap',
		[],
		null
	);
	wp_enqueue_style(
		'wp-wellness',
		get_stylesheet_uri(),
		[ 'wp-wellness-fonts' ],
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_style(
		'wp-wellness-main',
		get_template_directory_uri() . '/assets/css/main.css',
		[ 'wp-wellness' ],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'wpw_enqueue' );

// ── WooCommerce: remove default wrappers, add ours ───────────────────────────

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end' );

function wpw_woo_wrapper_start() {
	echo '<main class="wpw-main wpw-woo-main"><div class="wpw-container">';
}
function wpw_woo_wrapper_end() {
	echo '</div></main>';
}
add_action( 'woocommerce_before_main_content', 'wpw_woo_wrapper_start' );
add_action( 'woocommerce_after_main_content',  'wpw_woo_wrapper_end'   );

// ── WooCommerce: tweak loop columns ──────────────────────────────────────────

add_filter( 'loop_shop_columns', fn() => 3 );

// ── Customizer ────────────────────────────────────────────────────────────────

function wpw_customizer( $wp_customize ) {
	$wp_customize->add_section( 'wpw_hero', [
		'title'    => __( 'Hero Section', 'wp-wellness' ),
		'priority' => 30,
	] );

	$wp_customize->add_setting( 'wpw_hero_heading', [
		'default'           => 'Feel Better Every Day',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'wpw_hero_heading', [
		'label'   => __( 'Hero Heading', 'wp-wellness' ),
		'section' => 'wpw_hero',
		'type'    => 'text',
	] );

	$wp_customize->add_setting( 'wpw_hero_subheading', [
		'default'           => 'Science-backed supplements and wellness products for your best self.',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'wpw_hero_subheading', [
		'label'   => __( 'Hero Subheading', 'wp-wellness' ),
		'section' => 'wpw_hero',
		'type'    => 'textarea',
	] );

	$wp_customize->add_setting( 'wpw_hero_bg', [
		'default'           => '',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'wpw_hero_bg', [
		'label'     => __( 'Hero Background Image', 'wp-wellness' ),
		'section'   => 'wpw_hero',
		'mime_type' => 'image',
	] ) );
}
add_action( 'customize_register', 'wpw_customizer' );
