<?php get_header(); ?>
<?php

$queried_post_type = get_post_type();

if ( ! $queried_post_type && get_queried_object() instanceof WP_Post_Type ) {
    $queried_post_type = get_queried_object()->name;
}

?>
<div id="site-main">
    <?php if ( 'gated' == wealthiher_layout_slug() ): ?>
    <div class="main-header">
        <a href="<?php echo esc_url( wp_logout_url() ); ?>" class="button button-primary button-logout">Logout</a>
    </div>
    <?php endif; ?>
    <main class="site-main">
        <main id="entry-content" class="entry-content-<?php echo $queried_post_type; ?>">
            <?php get_template_part( 'template-parts/loop', $queried_post_type ); ?>
        </main>
        <?php get_template_part( 'template-parts/interest', wealthiher_layout_slug() ); ?>
    </main>
</div>
<?php get_footer();