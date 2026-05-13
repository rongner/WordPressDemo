<?php
defined( 'ABSPATH' ) || exit;

/**
 * Recent Posts with Thumbnail Widget
 *
 * Lists the N most-recent posts (or a chosen category) with their
 * featured image, title, date, and excerpt snippet.
 */
class WW_Recent_Posts_Thumb_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'ww_recent_posts_thumb',
			__( 'Recent Posts + Thumbnail', 'wellness-widgets' ),
			[
				'description' => __( 'Show recent posts with featured image and excerpt.', 'wellness-widgets' ),
				'classname'   => 'ww-widget ww-recent-posts',
			]
		);
	}

	public function widget( $args, $instance ) {
		$number   = ! empty( $instance['number'] )   ? absint( $instance['number'] )         : 5;
		$cat_id   = ! empty( $instance['cat_id'] )   ? absint( $instance['cat_id'] )          : 0;
		$show_date    = ! empty( $instance['show_date'] );
		$show_excerpt = ! empty( $instance['show_excerpt'] );
		$excerpt_len  = ! empty( $instance['excerpt_len'] ) ? absint( $instance['excerpt_len'] ) : 15;

		$query_args = [
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		];

		if ( $cat_id ) {
			$query_args['cat'] = $cat_id;
		}

		$posts = new WP_Query( $query_args );
		if ( ! $posts->have_posts() ) return;

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		}
		?>
		<ul class="ww-rp">
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<li class="ww-rp__item">
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="ww-rp__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php the_post_thumbnail( [ 72, 72 ] ); ?>
						</a>
					<?php endif; ?>

					<div class="ww-rp__body">
						<a class="ww-rp__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

						<?php if ( $show_date ) : ?>
							<time class="ww-rp__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						<?php endif; ?>

						<?php if ( $show_excerpt ) : ?>
							<p class="ww-rp__excerpt">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), $excerpt_len ) ); ?>
							</p>
						<?php endif; ?>
					</div>
				</li>
			<?php endwhile; wp_reset_postdata(); ?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title        = $instance['title']        ?? __( 'Recent Posts', 'wellness-widgets' );
		$number       = $instance['number']       ?? 5;
		$cat_id       = $instance['cat_id']       ?? 0;
		$show_date    = $instance['show_date']    ?? true;
		$show_excerpt = $instance['show_excerpt'] ?? false;
		$excerpt_len  = $instance['excerpt_len']  ?? 15;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wellness-widgets' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'wellness-widgets' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>"
				   type="number" min="1" max="20" value="<?php echo esc_attr( $number ); ?>" style="width:60px;">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>"><?php esc_html_e( 'Category ID (0 = all):', 'wellness-widgets' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'cat_id' ) ); ?>"
				   type="number" min="0" value="<?php echo esc_attr( $cat_id ); ?>" style="width:70px;">
		</p>
		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>"
				   type="checkbox" value="1" <?php checked( $show_date ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show date', 'wellness-widgets' ); ?></label>
		</p>
		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'show_excerpt' ) ); ?>"
				   type="checkbox" value="1" <?php checked( $show_excerpt ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"><?php esc_html_e( 'Show excerpt', 'wellness-widgets' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_len' ) ); ?>"><?php esc_html_e( 'Excerpt word count:', 'wellness-widgets' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_len' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'excerpt_len' ) ); ?>"
				   type="number" min="5" max="50" value="<?php echo esc_attr( $excerpt_len ); ?>" style="width:60px;">
		</p>
		<?php
	}

	public function update( $new, $old ) {
		return [
			'title'        => sanitize_text_field( $new['title'] ),
			'number'       => min( 20, max( 1, absint( $new['number'] ) ) ),
			'cat_id'       => absint( $new['cat_id'] ),
			'show_date'    => ! empty( $new['show_date'] ) ? 1 : 0,
			'show_excerpt' => ! empty( $new['show_excerpt'] ) ? 1 : 0,
			'excerpt_len'  => min( 50, max( 5, absint( $new['excerpt_len'] ) ) ),
		];
	}
}
