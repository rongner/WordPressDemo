<?php
defined( 'ABSPATH' ) || exit;

global $product;
?>
<li <?php wc_product_class( 'wpw-product-card', $product ); ?>>
    <a class="wpw-product-card__link" href="<?php echo esc_url( get_the_permalink() ); ?>">

        <div class="wpw-product-card__image">
            <?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'woocommerce_thumbnail', [ 'class' => 'wpw-product-card__img' ] );
            } else {
                echo wc_placeholder_img( 'woocommerce_thumbnail', [ 'class' => 'wpw-product-card__img' ] );
            }
            ?>
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="wpw-product-card__badge wpw-product-card__badge--sale"><?php esc_html_e( 'Sale', 'wp-wellness' ); ?></span>
            <?php endif; ?>
            <?php if ( $product->is_featured() ) : ?>
                <span class="wpw-product-card__badge wpw-product-card__badge--featured"><?php esc_html_e( 'Featured', 'wp-wellness' ); ?></span>
            <?php endif; ?>
        </div>

        <div class="wpw-product-card__body">
            <h3 class="wpw-product-card__title"><?php the_title(); ?></h3>

            <?php if ( $product->get_short_description() ) : ?>
                <p class="wpw-product-card__desc"><?php echo wp_kses_post( wp_trim_words( $product->get_short_description(), 12 ) ); ?></p>
            <?php endif; ?>

            <div class="wpw-product-card__footer">
                <span class="wpw-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
                <?php woocommerce_template_loop_rating(); ?>
            </div>
        </div>
    </a>

    <div class="wpw-product-card__add">
        <?php
        woocommerce_template_loop_add_to_cart( [
            'class' => implode( ' ', array_filter( [
                'wpw-btn',
                'wpw-btn--primary',
                'wpw-add-to-cart',
                'add_to_cart_button',
                $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
            ] ) ),
        ] );
        ?>
    </div>
</li>
