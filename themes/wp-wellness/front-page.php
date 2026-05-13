<?php get_header(); ?>

<!-- Hero ──────────────────────────────────────────────────────────────────── -->
<?php
$hero_bg_id  = get_theme_mod( 'wpw_hero_bg', '' );
$hero_bg_url = $hero_bg_id ? wp_get_attachment_image_url( $hero_bg_id, 'full' ) : '';
$hero_style  = $hero_bg_url ? ' style="background-image:url(' . esc_url( $hero_bg_url ) . ')"' : '';
?>
<section class="wpw-hero<?php echo $hero_bg_url ? ' wpw-hero--has-image' : ''; ?>"<?php echo $hero_style; ?>>
    <div class="wpw-hero__overlay"></div>
    <div class="wpw-container wpw-hero__content">
        <h1 class="wpw-hero__heading"><?php echo esc_html( get_theme_mod( 'wpw_hero_heading', 'Feel Better Every Day' ) ); ?></h1>
        <p class="wpw-hero__sub"><?php echo esc_html( get_theme_mod( 'wpw_hero_subheading', 'Science-backed supplements and wellness products for your best self.' ) ); ?></p>
        <div class="wpw-hero__actions">
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a class="wpw-btn wpw-btn--primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop Now</a>
            <?php endif; ?>
            <a class="wpw-btn wpw-btn--outline" href="#wpw-benefits">Learn More</a>
        </div>
    </div>
</section>

<!-- Featured Products ─────────────────────────────────────────────────────── -->
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="wpw-section wpw-featured">
    <div class="wpw-container">
        <h2 class="wpw-section__title">Best Sellers</h2>
        <p class="wpw-section__subtitle">Our most-loved products, backed by thousands of happy customers.</p>
        <?php echo do_shortcode( '[products limit="3" columns="3" best_selling="true"]' ); ?>
        <div class="wpw-featured__cta">
            <a class="wpw-btn wpw-btn--secondary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">View All Products</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Benefits ──────────────────────────────────────────────────────────────── -->
<section class="wpw-section wpw-benefits" id="wpw-benefits">
    <div class="wpw-container">
        <h2 class="wpw-section__title">Why Choose Us</h2>
        <div class="wpw-benefits__grid">
            <div class="wpw-benefit">
                <div class="wpw-benefit__icon">🌿</div>
                <h3>Natural Ingredients</h3>
                <p>Every formula uses clean, plant-based ingredients with no artificial fillers or preservatives.</p>
            </div>
            <div class="wpw-benefit">
                <div class="wpw-benefit__icon">🔬</div>
                <h3>Third-Party Tested</h3>
                <p>Independent lab testing on every batch ensures purity, potency, and safety you can trust.</p>
            </div>
            <div class="wpw-benefit">
                <div class="wpw-benefit__icon">♻️</div>
                <h3>Sustainable Packaging</h3>
                <p>100% recyclable packaging made from post-consumer materials because the planet matters.</p>
            </div>
            <div class="wpw-benefit">
                <div class="wpw-benefit__icon">👩‍⚕️</div>
                <h3>Expert Formulated</h3>
                <p>Developed with registered dietitians and sports scientists for real, measurable results.</p>
            </div>
        </div>
    </div>
</section>

<!-- Category Banner ───────────────────────────────────────────────────────── -->
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="wpw-section wpw-category-banner">
    <div class="wpw-container wpw-category-banner__grid">
        <a class="wpw-cat-card wpw-cat-card--supplements" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
            <div class="wpw-cat-card__content">
                <h3>Supplements</h3>
                <span>Shop &rarr;</span>
            </div>
        </a>
        <a class="wpw-cat-card wpw-cat-card--skincare" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
            <div class="wpw-cat-card__content">
                <h3>Skincare</h3>
                <span>Shop &rarr;</span>
            </div>
        </a>
        <a class="wpw-cat-card wpw-cat-card--fitness" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
            <div class="wpw-cat-card__content">
                <h3>Fitness</h3>
                <span>Shop &rarr;</span>
            </div>
        </a>
    </div>
</section>
<?php endif; ?>

<!-- Testimonials ──────────────────────────────────────────────────────────── -->
<section class="wpw-section wpw-testimonials">
    <div class="wpw-container">
        <h2 class="wpw-section__title">What Our Customers Say</h2>
        <div class="wpw-testimonials__grid">
            <blockquote class="wpw-testimonial">
                <p>"I've tried a lot of supplements but nothing has made a difference like this. My energy levels are through the roof after just two weeks."</p>
                <footer><strong>Sarah M.</strong> &mdash; Verified Buyer</footer>
            </blockquote>
            <blockquote class="wpw-testimonial">
                <p>"The skincare line is incredible. My skin has never looked better and I love that everything is clean and sustainably sourced."</p>
                <footer><strong>David K.</strong> &mdash; Verified Buyer</footer>
            </blockquote>
            <blockquote class="wpw-testimonial">
                <p>"Fast shipping, excellent quality, and the customer service team actually knows their products. This is my go-to wellness brand now."</p>
                <footer><strong>Priya L.</strong> &mdash; Verified Buyer</footer>
            </blockquote>
        </div>
    </div>
</section>

<!-- Newsletter CTA ────────────────────────────────────────────────────────── -->
<section class="wpw-section wpw-cta">
    <div class="wpw-container wpw-cta__inner">
        <h2>Get 10% Off Your First Order</h2>
        <p>Join our community and receive exclusive wellness tips, early access to new products, and your welcome discount.</p>
        <form class="wpw-cta__form" onsubmit="return false;">
            <input type="email" placeholder="Enter your email address" aria-label="Email address">
            <button type="submit" class="wpw-btn wpw-btn--primary">Subscribe</button>
        </form>
        <p class="wpw-cta__fine">No spam. Unsubscribe anytime.</p>
    </div>
</section>

<?php get_footer(); ?>
