<?php get_header(); ?>

<main class="site-main">

	<!-- Hero -->
	<section class="hero" aria-label="<?php esc_attr_e( 'Welcome', 'wp-restaurant' ); ?>">
		<div class="hero__overlay"></div>
		<div class="hero__content">
			<h1 class="hero__title"><?php bloginfo( 'name' ); ?></h1>
			<p class="hero__tagline"><?php bloginfo( 'description' ); ?></p>
			<a href="#reservations" class="hero__cta">
				<?php esc_html_e( 'Reserve a Table', 'wp-restaurant' ); ?>
			</a>
		</div>
	</section>

	<!-- Menu Highlights — renders Info Card blocks from page content -->
	<section class="menu-highlights" id="menu">
		<div class="section-inner">
			<h2 class="section-title">
				<?php esc_html_e( 'Menu Highlights', 'wp-restaurant' ); ?>
			</h2>
			<div class="cards-grid">
				<?php the_content(); ?>
			</div>
		</div>
	</section>

	<!-- About -->
	<section class="about" id="about">
		<div class="section-inner about__inner">
			<div class="about__image-wrap">
				<?php
				$about_img = get_theme_mod( 'about_image' );
				if ( $about_img ) {
					echo '<img src="' . esc_url( $about_img ) . '" alt="' . esc_attr__( 'Inside the restaurant', 'wp-restaurant' ) . '" class="about__image">';
				}
				?>
			</div>
			<div class="about__copy">
				<h2 class="section-title">
					<?php esc_html_e( 'Our Story', 'wp-restaurant' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'We believe great food starts with great ingredients. Our chefs source locally and cook seasonally, bringing you flavors that change with the harvest.', 'wp-restaurant' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Founded in 2008, we have been a gathering place for families, friends, and food lovers ever since.', 'wp-restaurant' ); ?>
				</p>
			</div>
		</div>
	</section>

	<!-- Reservations -->
	<section class="reservations" id="reservations">
		<div class="section-inner">
			<h2 class="section-title">
				<?php esc_html_e( 'Make a Reservation', 'wp-restaurant' ); ?>
			</h2>
			<form class="reservations__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'reservation_form', 'reservation_nonce' ); ?>
				<input type="hidden" name="action" value="reservation_submit">
				<div class="form-group">
					<label for="res-name"><?php esc_html_e( 'Name', 'wp-restaurant' ); ?></label>
					<input type="text" id="res-name" name="res_name" required>
				</div>
				<div class="form-group">
					<label for="res-email"><?php esc_html_e( 'Email', 'wp-restaurant' ); ?></label>
					<input type="email" id="res-email" name="res_email" required>
				</div>
				<div class="form-group">
					<label for="res-date"><?php esc_html_e( 'Date', 'wp-restaurant' ); ?></label>
					<input type="date" id="res-date" name="res_date" required>
				</div>
				<div class="form-group">
					<label for="res-guests"><?php esc_html_e( 'Guests', 'wp-restaurant' ); ?></label>
					<select id="res-guests" name="res_guests">
						<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
							<option value="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></option>
						<?php endfor; ?>
					</select>
				</div>
				<button type="submit" class="btn-primary">
					<?php esc_html_e( 'Request Reservation', 'wp-restaurant' ); ?>
				</button>
			</form>
		</div>
	</section>

</main>

<?php get_footer(); ?>
