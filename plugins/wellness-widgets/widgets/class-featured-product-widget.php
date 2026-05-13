<?php
defined( 'ABSPATH' ) || exit;

/**
 * Featured Product Widget
 *
 * Displays a single WooCommerce product by ID with thumbnail, price,
 * short description, and an Add to Cart button.
 */
class WW_Featured_Product_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'ww_featured_product',
			__( 'Featured Product', 'wellness-widgets' ),
			[
				'description' => __( 'Highlight a single WooCommerce product in any sidebar.', 'wellness-widgets' ),
				'classname'   => 'ww-widget ww-featured-product',
			]
		);
	}

	/**
	 * Front-end output.
	 */
	public function widget( $args, $instance ) {
		if ( ! class_exists( 'WooCommerce' ) ) return;

		$product_id = ! empty( $instance['product_id'] ) ? absint( $instance['product_id'] ) : 0;
		$label      = ! empty( $instance['label'] )      ? esc_html( $instance['label'] )    : __( 'Featured', 'wellness-widgets' );

		if ( ! $product_id ) return;

		$product = wc_get_product( $product_id );
		if ( ! $product || ! $product->is_visible() ) return;

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		}
		?>
		<div class="ww-fp">
			<?php if ( $product->get_image_id() ) : ?>
				<a class="ww-fp__image" href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo $product->get_image( 'thumbnail' ); ?>
					<span class="ww-fp__label"><?php echo esc_html( $label ); ?></span>
				</a>
			<?php endif; ?>

			<div class="ww-fp__body">
				<h4 class="ww-fp__name">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
				</h4>

				<?php if ( $product->get_short_description() ) : ?>
					<p class="ww-fp__desc"><?php echo wp_kses_post( wp_trim_words( $product->get_short_description(), 15 ) ); ?></p>
				<?php endif; ?>

				<div class="ww-fp__footer">
					<span class="ww-fp__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					<?php
					echo apply_filters(
						'woocommerce_loop_add_to_cart_link',
						sprintf(
							'<a href="%s" data-product_id="%d" data-product_sku="%s" class="ww-btn add_to_cart_button ajax_add_to_cart">%s</a>',
							esc_url( $product->add_to_cart_url() ),
							esc_attr( $product->get_id() ),
							esc_attr( $product->get_sku() ),
							esc_html( $product->add_to_cart_text() )
						),
						$product
					);
					?>
				</div>
			</div>
		</div>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Admin form.
	 */
	public function form( $instance ) {
		$title      = $instance['title']      ?? __( 'Featured Product', 'wellness-widgets' );
		$product_id = $instance['product_id'] ?? '';
		$label      = $instance['label']      ?? __( 'Featured', 'wellness-widgets' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'product_id' ) ); ?>"><?php esc_html_e( 'Product ID:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'product_id' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'product_id' ) ); ?>"
				   type="number" min="1" value="<?php echo esc_attr( $product_id ); ?>">
			<small><?php esc_html_e( 'Find the ID on the product edit screen in wp-admin.', 'wellness-widgets' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Badge Label:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $label ); ?>">
		</p>
		<?php
	}

	/**
	 * Save settings.
	 */
	public function update( $new, $old ) {
		return [
			'title'      => sanitize_text_field( $new['title'] ),
			'product_id' => absint( $new['product_id'] ),
			'label'      => sanitize_text_field( $new['label'] ),
		];
	}
}
