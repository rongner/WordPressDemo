<?php get_header(); ?>

<main class="wpw-main">
    <div class="wpw-container wpw-page-content">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 class="wpw-page-title"><?php the_title(); ?></h1>
            <div class="wpw-entry-content"><?php the_content(); ?></div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
