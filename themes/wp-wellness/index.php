<?php get_header(); ?>

<main class="wpw-main">
    <div class="wpw-container wpw-blog">

        <h1 class="wpw-page-title">
            <?php
            if ( is_home() && ! is_front_page() ) {
                single_post_title();
            } elseif ( is_search() ) {
                printf( esc_html__( 'Search results for: %s', 'wp-wellness' ), get_search_query() );
            } elseif ( is_archive() ) {
                the_archive_title();
            } else {
                esc_html_e( 'Latest Posts', 'wp-wellness' );
            }
            ?>
        </h1>

        <?php if ( have_posts() ) : ?>
            <div class="wpw-posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'wpw-post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a class="wpw-post-card__thumb" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="wpw-post-card__body">
                            <p class="wpw-post-card__date"><?php echo esc_html( get_the_date() ); ?></p>
                            <h2 class="wpw-post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="wpw-post-card__excerpt"><?php the_excerpt(); ?></div>
                            <a class="wpw-btn wpw-btn--text" href="<?php the_permalink(); ?>">Read More &rarr;</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="wpw-pagination">
                <?php the_posts_pagination( [ 'mid_size' => 2 ] ); ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'wp-wellness' ); ?></p>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
