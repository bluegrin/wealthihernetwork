<?php
/**
 * Default Page Template
 */
?>
<?php get_header(); ?>
<div id="site-main">
    <?php if ( 'gated' == wealthiher_layout_slug() ): ?>
    <div class="main-header">
        <a href="<?php echo esc_url( wp_logout_url() ); ?>" class="button button-primary button-logout">Logout</a>
    </div>
    <?php endif; ?>
    <main class="site-main">
        <?php get_template_part( 'template-parts/title', wealthiher_layout_slug() ); ?>
        <?php get_template_part( 'template-parts/secondary-nav', wealthiher_layout_slug() ); ?>
        <main id="entry-content">
            <?php the_content(); ?>
        </main>
    </main>
</div>
<?php get_footer();
