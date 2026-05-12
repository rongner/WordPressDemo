<?php get_header(); ?>

<main class="site-main">

	<!-- Hero — split-screen: copy left, gradient right -->
	<section class="hero" aria-label="<?php esc_attr_e( 'Welcome', 'wp-droffice' ); ?>">
		<div class="hero__copy">
			<p class="hero__eyebrow">
				<?php esc_html_e( 'Board-Certified Family Medicine', 'wp-droffice' ); ?>
			</p>
			<h1 class="hero__title"><?php bloginfo( 'name' ); ?></h1>
			<p class="hero__tagline"><?php bloginfo( 'description' ); ?></p>
			<a href="#contact" class="btn-primary">
				<?php esc_html_e( 'Schedule an Appointment', 'wp-droffice' ); ?>
			</a>
		</div>
		<div class="hero__accent" aria-hidden="true"></div>
	</section>

	<!-- Services — renders Info Card blocks from page content -->
	<section class="services" id="services">
		<div class="section-inner">
			<h2 class="section-title">
				<?php esc_html_e( 'Our Services', 'wp-droffice' ); ?>
			</h2>
			<div class="cards-grid">
				<?php the_content(); ?>
			</div>
		</div>
	</section>

	<!-- About the Doctor -->
	<section class="about" id="about">
		<div class="section-inner about__inner">
			<div class="about__image-wrap">
				<?php
				$doctor_img = get_theme_mod( 'doctor_image' );
				if ( $doctor_img ) {
					echo '<img src="' . esc_url( $doctor_img ) . '" alt="' . esc_attr__( 'Dr. Smith', 'wp-droffice' ) . '" class="about__image">';
				}
				?>
			</div>
			<div class="about__copy">
				<h2 class="section-title">
					<?php esc_html_e( 'About the Doctor', 'wp-droffice' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'Dr. Smith has over 20 years of experience providing compassionate, evidence-based care to patients of all ages. She is dedicated to building lasting relationships with her patients and their families.', 'wp-droffice' ); ?>
				</p>
				<ul class="credentials">
					<li><?php esc_html_e( 'M.D., State University School of Medicine', 'wp-droffice' ); ?></li>
					<li><?php esc_html_e( 'Board Certified, American Board of Family Medicine', 'wp-droffice' ); ?></li>
					<li><?php esc_html_e( 'Member, American Academy of Family Physicians', 'wp-droffice' ); ?></li>
				</ul>
			</div>
		</div>
	</section>

	<!-- Contact & Hours -->
	<section class="contact" id="contact">
		<div class="section-inner contact__inner">
			<div class="contact__info">
				<h2 class="section-title">
					<?php esc_html_e( 'Contact &amp; Hours', 'wp-droffice' ); ?>
				</h2>
				<p>
					<?php esc_html_e( '456 Medical Blvd, Suite 100', 'wp-droffice' ); ?><br>
					<?php esc_html_e( 'Anytown, USA 12345', 'wp-droffice' ); ?><br>
					<a href="tel:+15559876543">(555) 987-6543</a>
				</p>
				<table class="hours-table">
					<tbody>
						<tr><th><?php esc_html_e( 'Mon – Fri', 'wp-droffice' ); ?></th><td>8am – 5pm</td></tr>
						<tr><th><?php esc_html_e( 'Saturday', 'wp-droffice' ); ?></th><td>9am – 12pm</td></tr>
						<tr><th><?php esc_html_e( 'Sunday', 'wp-droffice' ); ?></th><td><?php esc_html_e( 'Closed', 'wp-droffice' ); ?></td></tr>
					</tbody>
				</table>
			</div>
			<form class="contact__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'appointment_form', 'appointment_nonce' ); ?>
				<input type="hidden" name="action" value="appointment_submit">
				<h3 class="contact__form-title">
					<?php esc_html_e( 'Request an Appointment', 'wp-droffice' ); ?>
				</h3>
				<div class="form-group">
					<label for="appt-name"><?php esc_html_e( 'Full Name', 'wp-droffice' ); ?></label>
					<input type="text" id="appt-name" name="appt_name" required>
				</div>
				<div class="form-group">
					<label for="appt-phone"><?php esc_html_e( 'Phone', 'wp-droffice' ); ?></label>
					<input type="tel" id="appt-phone" name="appt_phone" required>
				</div>
				<div class="form-group">
					<label for="appt-date"><?php esc_html_e( 'Preferred Date', 'wp-droffice' ); ?></label>
					<input type="date" id="appt-date" name="appt_date" required>
				</div>
				<div class="form-group">
					<label for="appt-reason"><?php esc_html_e( 'Reason for Visit', 'wp-droffice' ); ?></label>
					<textarea id="appt-reason" name="appt_reason" rows="3"></textarea>
				</div>
				<button type="submit" class="btn-primary">
					<?php esc_html_e( 'Submit Request', 'wp-droffice' ); ?>
				</button>
			</form>
		</div>
	</section>

</main>

<?php get_footer(); ?>
