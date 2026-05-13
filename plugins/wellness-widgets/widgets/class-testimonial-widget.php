<?php
defined( 'ABSPATH' ) || exit;

/**
 * Testimonial Widget
 *
 * Displays a customer quote with author name, role/source,
 * avatar image, and a 1–5 star rating.
 */
class WW_Testimonial_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'ww_testimonial',
			__( 'Testimonial', 'wellness-widgets' ),
			[
				'description' => __( 'Display a customer quote with star rating and author.', 'wellness-widgets' ),
				'classname'   => 'ww-widget ww-testimonial',
			]
		);
	}

	public function widget( $args, $instance ) {
		$quote     = ! empty( $instance['quote'] )     ? wp_kses_post( $instance['quote'] )     : '';
		$author    = ! empty( $instance['author'] )    ? esc_html( $instance['author'] )        : '';
		$role      = ! empty( $instance['role'] )      ? esc_html( $instance['role'] )          : '';
		$rating    = ! empty( $instance['rating'] )    ? min( 5, max( 1, absint( $instance['rating'] ) ) ) : 5;
		$avatar_id = ! empty( $instance['avatar_id'] ) ? absint( $instance['avatar_id'] )       : 0;

		if ( ! $quote ) return;

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		}
		?>
		<div class="ww-testimonial">
			<div class="ww-testimonial__stars" aria-label="<?php printf( esc_attr__( '%d out of 5 stars', 'wellness-widgets' ), $rating ); ?>">
				<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<span class="ww-testimonial__star<?php echo $i <= $rating ? ' is-filled' : ''; ?>" aria-hidden="true">&#9733;</span>
				<?php endfor; ?>
			</div>

			<blockquote class="ww-testimonial__quote">
				<p><?php echo wp_kses_post( $quote ); ?></p>
			</blockquote>

			<div class="ww-testimonial__author">
				<?php if ( $avatar_id ) : ?>
					<?php echo wp_get_attachment_image( $avatar_id, [ 48, 48 ], false, [ 'class' => 'ww-testimonial__avatar' ] ); ?>
				<?php else : ?>
					<span class="ww-testimonial__avatar-placeholder" aria-hidden="true">
						<?php echo esc_html( mb_substr( $author, 0, 1 ) ); ?>
					</span>
				<?php endif; ?>
				<div class="ww-testimonial__meta">
					<?php if ( $author ) : ?>
						<strong class="ww-testimonial__name"><?php echo esc_html( $author ); ?></strong>
					<?php endif; ?>
					<?php if ( $role ) : ?>
						<span class="ww-testimonial__role"><?php echo esc_html( $role ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title     = $instance['title']     ?? '';
		$quote     = $instance['quote']     ?? '';
		$author    = $instance['author']    ?? '';
		$role      = $instance['role']      ?? __( 'Verified Buyer', 'wellness-widgets' );
		$rating    = $instance['rating']    ?? 5;
		$avatar_id = $instance['avatar_id'] ?? 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'quote' ) ); ?>"><?php esc_html_e( 'Quote:', 'wellness-widgets' ); ?></label>
			<textarea class="widefat" rows="4" id="<?php echo esc_attr( $this->get_field_id( 'quote' ) ); ?>"
					  name="<?php echo esc_attr( $this->get_field_name( 'quote' ) ); ?>"><?php echo esc_textarea( $quote ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>"><?php esc_html_e( 'Author Name:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'author' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $author ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'role' ) ); ?>"><?php esc_html_e( 'Author Role / Source:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'role' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'role' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $role ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rating' ) ); ?>"><?php esc_html_e( 'Star Rating (1–5):', 'wellness-widgets' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'rating' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'rating' ) ); ?>"
				   type="number" min="1" max="5" value="<?php echo esc_attr( $rating ); ?>" style="width:60px;">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar_id' ) ); ?>"><?php esc_html_e( 'Avatar Image ID:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'avatar_id' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'avatar_id' ) ); ?>"
				   type="number" min="0" value="<?php echo esc_attr( $avatar_id ); ?>">
			<small><?php esc_html_e( 'Leave 0 to use an initial placeholder.', 'wellness-widgets' ); ?></small>
		</p>
		<?php
	}

	public function update( $new, $old ) {
		return [
			'title'     => sanitize_text_field( $new['title'] ),
			'quote'     => wp_kses_post( $new['quote'] ),
			'author'    => sanitize_text_field( $new['author'] ),
			'role'      => sanitize_text_field( $new['role'] ),
			'rating'    => min( 5, max( 1, absint( $new['rating'] ) ) ),
			'avatar_id' => absint( $new['avatar_id'] ),
		];
	}
}
