<footer class="wpw-footer">
    <div class="wpw-container wpw-footer__inner">

        <div class="wpw-footer__brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wpw-footer__logo">
                <?php bloginfo( 'name' ); ?>
            </a>
            <p class="wpw-footer__tagline"><?php bloginfo( 'description' ); ?></p>
        </div>

        <nav class="wpw-footer__nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'wp-wellness' ); ?>">
            <?php wp_nav_menu( [
                'theme_location' => 'footer',
                'menu_class'     => 'wpw-footer__list',
                'container'      => false,
                'fallback_cb'    => false,
            ] ); ?>
        </nav>

        <div class="wpw-footer__trust">
            <span>🌿 Natural Ingredients</span>
            <span>🔬 Third-Party Tested</span>
            <span>🚚 Free Shipping $50+</span>
        </div>

    </div>
    <div class="wpw-footer__bottom">
        <div class="wpw-container">
            <p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
