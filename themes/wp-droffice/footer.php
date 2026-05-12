<footer class="site-footer">
	<div class="site-footer__inner">
		<div class="site-footer__block">
			<h3 class="site-footer__heading">
				<?php esc_html_e( 'Office Hours', 'wp-droffice' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'Mon – Fri: 8am – 5pm', 'wp-droffice' ); ?><br>
				<?php esc_html_e( 'Sat: 9am – 12pm', 'wp-droffice' ); ?><br>
				<?php esc_html_e( 'Sun: Closed', 'wp-droffice' ); ?>
			</p>
		</div>
		<div class="site-footer__block">
			<h3 class="site-footer__heading">
				<?php esc_html_e( 'Contact', 'wp-droffice' ); ?>
			</h3>
			<p>
				<?php esc_html_e( '456 Medical Blvd, Suite 100', 'wp-droffice' ); ?><br>
				<?php esc_html_e( 'Anytown, USA 12345', 'wp-droffice' ); ?><br>
				<a href="tel:+15559876543">(555) 987-6543</a>
			</p>
		</div>
		<p class="site-footer__copy">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
			<?php bloginfo( 'name' ); ?>.
			<?php esc_html_e( 'All rights reserved.', 'wp-droffice' ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
