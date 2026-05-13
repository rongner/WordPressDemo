<?php
defined( 'ABSPATH' ) || exit;

class Portfolio_CPT {

	public function init() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'init', [ $this, 'register_taxonomy' ] );
	}

	public function register_post_type() {
		register_post_type( 'portfolio', [
			'labels' => [
				'name'               => __( 'Portfolio',        'portfolio-cpt' ),
				'singular_name'      => __( 'Project',          'portfolio-cpt' ),
				'add_new_item'       => __( 'Add New Project',  'portfolio-cpt' ),
				'edit_item'          => __( 'Edit Project',     'portfolio-cpt' ),
				'new_item'           => __( 'New Project',      'portfolio-cpt' ),
				'view_item'          => __( 'View Project',     'portfolio-cpt' ),
				'view_items'         => __( 'View Portfolio',   'portfolio-cpt' ),
				'search_items'       => __( 'Search Projects',  'portfolio-cpt' ),
				'not_found'          => __( 'No projects found.', 'portfolio-cpt' ),
				'not_found_in_trash' => __( 'No projects found in Trash.', 'portfolio-cpt' ),
				'all_items'          => __( 'All Projects',     'portfolio-cpt' ),
				'menu_name'          => __( 'Portfolio',        'portfolio-cpt' ),
			],
			'public'              => true,
			'has_archive'         => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-portfolio',
			'menu_position'       => 20,
			'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
			'rewrite'             => [ 'slug' => 'portfolio', 'with_front' => false ],
		] );
	}

	public function register_taxonomy() {
		register_taxonomy( 'portfolio_type', 'portfolio', [
			'labels' => [
				'name'              => __( 'Project Types',    'portfolio-cpt' ),
				'singular_name'     => __( 'Project Type',     'portfolio-cpt' ),
				'search_items'      => __( 'Search Types',     'portfolio-cpt' ),
				'all_items'         => __( 'All Types',        'portfolio-cpt' ),
				'parent_item'       => __( 'Parent Type',      'portfolio-cpt' ),
				'parent_item_colon' => __( 'Parent Type:',     'portfolio-cpt' ),
				'edit_item'         => __( 'Edit Type',        'portfolio-cpt' ),
				'update_item'       => __( 'Update Type',      'portfolio-cpt' ),
				'add_new_item'      => __( 'Add New Type',     'portfolio-cpt' ),
				'new_item_name'     => __( 'New Type Name',    'portfolio-cpt' ),
				'menu_name'         => __( 'Project Types',    'portfolio-cpt' ),
			],
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => false, // managed manually in Portfolio_Columns
			'rewrite'           => [ 'slug' => 'portfolio-type' ],
		] );
	}
}
