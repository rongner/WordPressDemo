<?php
defined( 'ABSPATH' ) || exit;

/**
 * Promo Banner Widget
 *
 * Displays a configurable banner with background image, headline,
 * subtext, and a CTA button. Fully editable from the widget admin.
 */
class WW_Promo_Banner_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'ww_promo_banner',
			__( 'Promo Banner', 'wellness-widgets' ),
			[
				'description' => __( 'A configurable banner with image, headline, and CTA button.', 'wellness-widgets' ),
				'classname'   => 'ww-widget ww-promo-banner',
			]
		);
	}

	public function widget( $args, $instance ) {
		$heading    = ! empty( $instance['heading'] )    ? esc_html( $instance['heading'] )    : '';
		$subtext    = ! empty( $instance['subtext'] )    ? esc_html( $instance['subtext'] )    : '';
		$btn_label  = ! empty( $instance['btn_label'] )  ? esc_html( $instance['btn_label'] )  : '';
		$btn_url    = ! empty( $instance['btn_url'] )    ? esc_url( $instance['btn_url'] )     : '';
		$image_id   = ! empty( $instance['image_id'] )   ? absint( $instance['image_id'] )     : 0;
		$bg_color   = ! empty( $instance['bg_color'] )   ? sanitize_hex_color( $instance['bg_color'] ) : '#4a7c59';

		if ( ! $heading ) return;

		$image_url  = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
		$bg_style   = $image_url
			? "background-image:url(" . esc_url( $image_url ) . ");background-color:" . esc_attr( $bg_color ) . ";"
			: "background-color:" . esc_attr( $bg_color ) . ";";

		echo $args['before_widget'];
		?>
		<div class="ww-promo" style="<?php echo $bg_style; ?>">
			<div class="ww-promo__overlay"></div>
			<div class="ww-promo__content">
				<h4 class="ww-promo__heading"><?php echo esc_html( $heading ); ?></h4>
				<?php if ( $subtext ) : ?>
					<p class="ww-promo__subtext"><?php echo esc_html( $subtext ); ?></p>
				<?php endif; ?>
				<?php if ( $btn_label && $btn_url ) : ?>
					<a class="ww-btn ww-btn--outline" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_label ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$heading   = $instance['heading']   ?? __( 'Get 20% Off Today', 'wellness-widgets' );
		$subtext   = $instance['subtext']   ?? __( 'Use code WELLNESS at checkout.', 'wellness-widgets' );
		$btn_label = $instance['btn_label'] ?? __( 'Shop Now', 'wellness-widgets' );
		$btn_url   = $instance['btn_url']   ?? '';
		$image_id  = $instance['image_id']  ?? 0;
		$bg_color  = $instance['bg_color']  ?? '#4a7c59';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $heading ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'subtext' ) ); ?>"><?php esc_html_e( 'Subtext:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtext' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'subtext' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $subtext ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_label' ) ); ?>"><?php esc_html_e( 'Button Label:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_label' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'btn_label' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $btn_label ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_url' ) ); ?>"><?php esc_html_e( 'Button URL:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_url' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'btn_url' ) ); ?>"
				   type="url" value="<?php echo esc_attr( $btn_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"><?php esc_html_e( 'Background Image ID:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>"
				   type="number" min="0" value="<?php echo esc_attr( $image_id ); ?>">
			<small><?php esc_html_e( 'Leave 0 to use background color only.', 'wellness-widgets' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>"><?php esc_html_e( 'Background Color:', 'wellness-widgets' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>"
				   type="color" value="<?php echo esc_attr( $bg_color ); ?>">
		</p>
		<?php
	}

	public function update( $new, $old ) {
		return [
			'heading'   => sanitize_text_field( $new['heading'] ),
			'subtext'   => sanitize_text_field( $new['subtext'] ),
			'btn_label' => sanitize_text_field( $new['btn_label'] ),
			'btn_url'   => esc_url_raw( $new['btn_url'] ),
			'image_id'  => absint( $new['image_id'] ),
			'bg_color'  => sanitize_hex_color( $new['bg_color'] ) ?: '#4a7c59',
		];
	}
}
