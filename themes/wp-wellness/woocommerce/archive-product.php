<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="wpw-main wpw-woo-main">
    <div class="wpw-container">

        <!-- Shop header -->
        <div class="wpw-shop-header">
            <?php woocommerce_page_title(); ?>
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <?php do_action( 'woocommerce_archive_description' ); ?>
            <?php endif; ?>
        </div>

        <?php if ( woocommerce_product_loop() ) : ?>

            <!-- Toolbar: result count + ordering -->
            <div class="wpw-shop-toolbar">
                <?php woocommerce_result_count(); ?>
                <?php woocommerce_catalog_ordering(); ?>
            </div>

            <?php woocommerce_product_loop_start(); ?>

                <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                    <?php while ( have_posts() ) : ?>
                        <?php the_post(); ?>
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    <?php endwhile; ?>
                <?php endif; ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            woocommerce_pagination();
            ?>

        <?php else : ?>
            <?php do_action( 'woocommerce_no_products_found' ); ?>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
