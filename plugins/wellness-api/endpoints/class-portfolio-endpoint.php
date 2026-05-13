<?php
defined( 'ABSPATH' ) || exit;

/**
 * GET  /wp-json/wellness/v1/portfolio          — paginated list
 * GET  /wp-json/wellness/v1/portfolio/{id}     — single project
 *
 * Query params (list):
 *   per_page  int  1–100, default 10
 *   page      int  default 1
 *   type      string  portfolio_type slug filter
 *   search    string  keyword search
 */
class Wellness_Portfolio_Endpoint {

	private const NS   = 'wellness/v1';
	private const BASE = 'portfolio';

	public function register_routes() {
		register_rest_route( self::NS, '/' . self::BASE, [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_items' ],
				'permission_callback' => '__return_true',
				'args'                => $this->collection_args(),
			],
			'schema' => [ $this, 'get_item_schema' ],
		] );

		register_rest_route( self::NS, '/' . self::BASE . '/(?P<id>[\d]+)', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_item' ],
				'permission_callback' => '__return_true',
				'args'                => [
					'id' => [
						'description'       => __( 'Portfolio project ID.', 'wellness-api' ),
						'type'              => 'integer',
						'required'          => true,
						'sanitize_callback' => 'absint',
						'validate_callback' => function( $v ) { return $v > 0; },
					],
				],
			],
			'schema' => [ $this, 'get_item_schema' ],
		] );
	}

	// -------------------------------------------------------------------------

	public function get_items( WP_REST_Request $request ) {
		$per_page = $request->get_param( 'per_page' ) ?? 10;
		$page     = $request->get_param( 'page' )     ?? 1;
		$type     = $request->get_param( 'type' );
		$search   = $request->get_param( 'search' );

		$args = [
			'post_type'      => 'portfolio',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => $page,
			'orderby'        => 'date',
			'order'          => 'DESC',
		];

		if ( $type ) {
			$args['tax_query'] = [ [
				'taxonomy' => 'portfolio_type',
				'field'    => 'slug',
				'terms'    => sanitize_key( $type ),
			] ];
		}

		if ( $search ) {
			$args['s'] = sanitize_text_field( $search );
		}

		$query = new WP_Query( $args );
		$items = [];

		foreach ( $query->posts as $post ) {
			$items[] = $this->prepare_item( $post );
		}

		$response = new WP_REST_Response( $items, 200 );
		$response->header( 'X-WP-Total',      $query->found_posts );
		$response->header( 'X-WP-TotalPages', $query->max_num_pages );

		return $response;
	}

	public function get_item( WP_REST_Request $request ) {
		$post = get_post( $request->get_param( 'id' ) );

		if ( ! $post || $post->post_type !== 'portfolio' || $post->post_status !== 'publish' ) {
			return new WP_Error(
				'portfolio_not_found',
				__( 'Project not found.', 'wellness-api' ),
				[ 'status' => 404 ]
			);
		}

		return new WP_REST_Response( $this->prepare_item( $post ), 200 );
	}

	// -------------------------------------------------------------------------

	private function prepare_item( WP_Post $post ): array {
		$terms = get_the_terms( $post->ID, 'portfolio_type' );
		$types = ( $terms && ! is_wp_error( $terms ) )
			? array_map( fn( $t ) => [ 'id' => $t->term_id, 'name' => $t->name, 'slug' => $t->slug ], $terms )
			: [];

		$thumb_id  = get_post_thumbnail_id( $post->ID );
		$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : null;

		return [
			'id'          => $post->ID,
			'title'       => get_the_title( $post ),
			'slug'        => $post->post_name,
			'excerpt'     => get_the_excerpt( $post ),
			'permalink'   => get_permalink( $post ),
			'featured_image' => $thumb_url,
			'project_url' => get_post_meta( $post->ID, '_portfolio_url',    true ) ?: null,
			'client'      => get_post_meta( $post->ID, '_portfolio_client', true ) ?: null,
			'year'        => (int) get_post_meta( $post->ID, '_portfolio_year', true ) ?: null,
			'types'       => $types,
			'date'        => mysql_to_rfc3339( $post->post_date_gmt ),
		];
	}

	// -------------------------------------------------------------------------

	private function collection_args(): array {
		return [
			'per_page' => [
				'description'       => __( 'Items per page (1–100).', 'wellness-api' ),
				'type'              => 'integer',
				'default'           => 10,
				'minimum'           => 1,
				'maximum'           => 100,
				'sanitize_callback' => 'absint',
			],
			'page' => [
				'description'       => __( 'Page number.', 'wellness-api' ),
				'type'              => 'integer',
				'default'           => 1,
				'minimum'           => 1,
				'sanitize_callback' => 'absint',
			],
			'type' => [
				'description'       => __( 'Filter by portfolio_type slug.', 'wellness-api' ),
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_key',
			],
			'search' => [
				'description'       => __( 'Keyword search.', 'wellness-api' ),
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			],
		];
	}

	public function get_item_schema(): array {
		return [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'portfolio-project',
			'type'       => 'object',
			'properties' => [
				'id'             => [ 'type' => 'integer', 'readonly' => true ],
				'title'          => [ 'type' => 'string' ],
				'slug'           => [ 'type' => 'string' ],
				'excerpt'        => [ 'type' => 'string' ],
				'permalink'      => [ 'type' => 'string', 'format' => 'uri' ],
				'featured_image' => [ 'type' => [ 'string', 'null' ], 'format' => 'uri' ],
				'project_url'    => [ 'type' => [ 'string', 'null' ], 'format' => 'uri' ],
				'client'         => [ 'type' => [ 'string', 'null' ] ],
				'year'           => [ 'type' => [ 'integer', 'null' ] ],
				'types'          => [
					'type'  => 'array',
					'items' => [
						'type'       => 'object',
						'properties' => [
							'id'   => [ 'type' => 'integer' ],
							'name' => [ 'type' => 'string' ],
							'slug' => [ 'type' => 'string' ],
						],
					],
				],
				'date' => [ 'type' => 'string', 'format' => 'date-time' ],
			],
		];
	}
}
