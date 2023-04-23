<?php

get_header();

?>
<div id="site-main">
    <?php if ( 'gated' == wealthiher_layout_slug() ): ?>
    <div class="main-header">
        <a href="<?php echo esc_url( wp_logout_url() ); ?>" class="button button-primary button-logout">Logout</a>
    </div>
    <?php endif; ?>
    <main class="site-main">
        <main id="entry-content" class="entry-content-<?php echo get_post_type(); ?>">
            <?php

            if ( 'gated' == wealthiher_layout_slug() && get_queried_object() instanceof WP_Post_Type ) {
                get_template_part( 'template-parts/title', wealthiher_layout_slug(), array( 'title' => __wh( 'WealthiHer Events' ) ) );
                get_template_part( 'template-parts/events', wealthiher_layout_slug() );
            } else {
                echo tribe( Tribe\Events\Views\V2\Template_Bootstrap::class )->get_view_html();
            }
            
            ?>
        </main>
    </main>
</div>
<?php

get_footer();
