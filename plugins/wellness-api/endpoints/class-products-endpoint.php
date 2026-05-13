<?php
defined( 'ABSPATH' ) || exit;

/**
 * GET  /wp-json/wellness/v1/products           — paginated list
 * GET  /wp-json/wellness/v1/products/{id}      — single product
 *
 * Requires WooCommerce. Returns 503 if WooCommerce is inactive.
 *
 * Query params (list):
 *   per_page    int     1–100, default 12
 *   page        int     default 1
 *   category    string  product category slug filter
 *   on_sale     bool    filter to sale items only
 *   featured    bool    filter to featured products only
 *   orderby     string  date|price|popularity|rating (default: date)
 *   order       string  asc|desc (default: desc)
 */
class Wellness_Products_Endpoint {

	private const NS   = 'wellness/v1';
	private const BASE = 'products';

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
		if ( ! $this->woo_active() ) {
			return $this->woo_error();
		}

		$per_page = $request->get_param( 'per_page' ) ?? 12;
		$page     = $request->get_param( 'page' )     ?? 1;
		$category = $request->get_param( 'category' );
		$on_sale  = $request->get_param( 'on_sale' );
		$featured = $request->get_param( 'featured' );
		$orderby  = $request->get_param( 'orderby' ) ?? 'date';
		$order    = strtoupper( $request->get_param( 'order' ) ?? 'DESC' );

		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => $page,
			'order'          => in_array( $order, [ 'ASC', 'DESC' ] ) ? $order : 'DESC',
		];

		// Map orderby to WP_Query
		$orderby_map = [
			'date'       => [ 'orderby' => 'date' ],
			'price'      => [ 'orderby' => 'meta_value_num', 'meta_key' => '_price' ],
			'popularity' => [ 'orderby' => 'meta_value_num', 'meta_key' => 'total_sales' ],
			'rating'     => [ 'orderby' => 'meta_value_num', 'meta_key' => '_wc_average_rating' ],
		];
		$args = array_merge( $args, $orderby_map[ $orderby ] ?? $orderby_map['date'] );

		$tax_query = [];

		if ( $category ) {
			$tax_query[] = [
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => sanitize_key( $category ),
			];
		}

		if ( $featured ) {
			$tax_query[] = [
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			];
		}

		if ( $tax_query ) {
			$args['tax_query'] = $tax_query;
		}

		if ( $on_sale ) {
			$args['post__in'] = array_merge( [ 0 ], wc_get_product_ids_on_sale() );
		}

		$query = new WP_Query( $args );
		$items = [];

		foreach ( $query->posts as $post ) {
			$product = wc_get_product( $post->ID );
			if ( $product ) {
				$items[] = $this->prepare_item( $product );
			}
		}

		$response = new WP_REST_Response( $items, 200 );
		$response->header( 'X-WP-Total',      $query->found_posts );
		$response->header( 'X-WP-TotalPages', $query->max_num_pages );

		return $response;
	}

	public function get_item( WP_REST_Request $request ) {
		if ( ! $this->woo_active() ) {
			return $this->woo_error();
		}

		$product = wc_get_product( $request->get_param( 'id' ) );

		if ( ! $product || ! $product->is_visible() ) {
			return new WP_Error(
				'product_not_found',
				__( 'Product not found.', 'wellness-api' ),
				[ 'status' => 404 ]
			);
		}

		return new WP_REST_Response( $this->prepare_item( $product ), 200 );
	}

	// -------------------------------------------------------------------------

	private function prepare_item( WC_Product $product ): array {
		$image_id  = $product->get_image_id();
		$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'woocommerce_single' ) : wc_placeholder_img_src();

		$cats  = get_the_terms( $product->get_id(), 'product_cat' );
		$categories = ( $cats && ! is_wp_error( $cats ) )
			? array_map( fn( $t ) => [ 'id' => $t->term_id, 'name' => $t->name, 'slug' => $t->slug ], $cats )
			: [];

		return [
			'id'                => $product->get_id(),
			'name'              => $product->get_name(),
			'slug'              => $product->get_slug(),
			'permalink'         => get_permalink( $product->get_id() ),
			'type'              => $product->get_type(),
			'price'             => $product->get_price(),
			'regular_price'     => $product->get_regular_price(),
			'sale_price'        => $product->get_sale_price() ?: null,
			'on_sale'           => $product->is_on_sale(),
			'price_html'        => $product->get_price_html(),
			'short_description' => wp_strip_all_tags( $product->get_short_description() ),
			'sku'               => $product->get_sku() ?: null,
			'in_stock'          => $product->is_in_stock(),
			'featured'          => $product->is_featured(),
			'average_rating'    => (float) $product->get_average_rating(),
			'rating_count'      => $product->get_rating_count(),
			'image'             => $image_url,
			'categories'        => $categories,
			'add_to_cart_url'   => $product->add_to_cart_url(),
		];
	}

	// -------------------------------------------------------------------------

	private function collection_args(): array {
		return [
			'per_page' => [
				'type'              => 'integer',
				'default'           => 12,
				'minimum'           => 1,
				'maximum'           => 100,
				'sanitize_callback' => 'absint',
			],
			'page' => [
				'type'              => 'integer',
				'default'           => 1,
				'minimum'           => 1,
				'sanitize_callback' => 'absint',
			],
			'category' => [
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_key',
			],
			'on_sale' => [
				'type'    => 'boolean',
				'default' => false,
			],
			'featured' => [
				'type'    => 'boolean',
				'default' => false,
			],
			'orderby' => [
				'type'              => 'string',
				'default'           => 'date',
				'enum'              => [ 'date', 'price', 'popularity', 'rating' ],
				'sanitize_callback' => 'sanitize_key',
			],
			'order' => [
				'type'              => 'string',
				'default'           => 'desc',
				'enum'              => [ 'asc', 'desc' ],
				'sanitize_callback' => 'sanitize_key',
			],
		];
	}

	public function get_item_schema(): array {
		return [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'wellness-product',
			'type'       => 'object',
			'properties' => [
				'id'                => [ 'type' => 'integer',           'readonly' => true ],
				'name'              => [ 'type' => 'string' ],
				'slug'              => [ 'type' => 'string' ],
				'permalink'         => [ 'type' => 'string', 'format' => 'uri' ],
				'type'              => [ 'type' => 'string' ],
				'price'             => [ 'type' => 'string' ],
				'regular_price'     => [ 'type' => 'string' ],
				'sale_price'        => [ 'type' => [ 'string', 'null' ] ],
				'on_sale'           => [ 'type' => 'boolean' ],
				'price_html'        => [ 'type' => 'string' ],
				'short_description' => [ 'type' => 'string' ],
				'sku'               => [ 'type' => [ 'string', 'null' ] ],
				'in_stock'          => [ 'type' => 'boolean' ],
				'featured'          => [ 'type' => 'boolean' ],
				'average_rating'    => [ 'type' => 'number' ],
				'rating_count'      => [ 'type' => 'integer' ],
				'image'             => [ 'type' => 'string', 'format' => 'uri' ],
				'categories'        => [
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
				'add_to_cart_url' => [ 'type' => 'string', 'format' => 'uri' ],
			],
		];
	}

	private function woo_active(): bool {
		return class_exists( 'WooCommerce' );
	}

	private function woo_error(): WP_Error {
		return new WP_Error(
			'woocommerce_required',
			__( 'WooCommerce must be active to use this endpoint.', 'wellness-api' ),
			[ 'status' => 503 ]
		);
	}
}
