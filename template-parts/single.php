<main class="site-main">
    <?php get_template_part( 'template-parts/title', wealthiher_layout_slug(), array( 'title' => get_post_type_labels( get_post_type_object( get_post_type() ) )->archives, 'subtitle' => get_the_title() ) ); ?>
    <main id="entry-content">
        <?php the_content(); ?>
    </main>
</main>
