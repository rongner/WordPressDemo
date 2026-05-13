<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="wpw-header">
    <div class="wpw-container wpw-header__inner">

        <a class="wpw-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="wpw-header__site-name"><?php bloginfo( 'name' ); ?></span>
            <?php endif; ?>
        </a>

        <nav class="wpw-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'wp-wellness' ); ?>">
            <?php wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_class'     => 'wpw-nav__list',
                'container'      => false,
                'fallback_cb'    => false,
            ] ); ?>
        </nav>

        <div class="wpw-header__actions">
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a class="wpw-header__cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'wp-wellness' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <?php if ( $count > 0 ) : ?>
                        <span class="wpw-header__cart-count"><?php echo esc_html( $count ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>

    </div>
</header>
