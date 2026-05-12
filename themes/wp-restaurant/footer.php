<footer class="site-footer">
	<div class="site-footer__inner">
		<div class="site-footer__info">
			<p class="site-footer__hours">
				<?php esc_html_e( 'Mon – Thu: 11am – 10pm', 'wp-restaurant' ); ?><br>
				<?php esc_html_e( 'Fri – Sat: 11am – 11pm', 'wp-restaurant' ); ?><br>
				<?php esc_html_e( 'Sun: 12pm – 9pm', 'wp-restaurant' ); ?>
			</p>
			<p class="site-footer__contact">
				<?php esc_html_e( '123 Main Street, Anytown, USA', 'wp-restaurant' ); ?><br>
				<a href="tel:+15551234567">(555) 123-4567</a>
			</p>
		</div>
		<p class="site-footer__copy">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
			<?php bloginfo( 'name' ); ?>.
			<?php esc_html_e( 'All rights reserved.', 'wp-restaurant' ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
