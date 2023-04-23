<?php

$lesson = new \memberpress\courses\models\Lesson( get_the_ID() );

?>
<?php get_header(); ?>
<div id="site-main">
    <?php if ( 'gated' == wealthiher_layout_slug() ): ?>
    <div class="main-header">
        <a href="<?php echo esc_url( wp_logout_url() ); ?>" class="button button-primary button-logout">Logout</a>
    </div>
    <?php endif; ?>
    <main class="site-main">
        <main id="entry-content" class="entry-content-<?php echo get_post_type(); ?>">
            <?php get_template_part( 'template-parts/breadcrumbs', wealthiher_layout_slug() ); ?>
            <?php get_template_part( 'template-parts/title', wealthiher_layout_slug() ); ?>
            <div class="columns">
                <div class="left">
                    <div class="content">
                        <?php $wh_skip_callouts = true; the_content(); unset( $wh_skip_callouts ); ?>
                        <button type="button" class="button button-secondary" id="quiz-save"><?php _ewh( 'Save' ); ?></button>
                    </div>
                </div>
                <div class="right">
                    <div class="callout">
                        <?php $wh_skip_callouts = false; the_content(); unset( $wh_skip_callouts ); ?>
                    </div>
                </div>
            </div>
            <?php get_template_part( 'template-parts/lesson-nav', wealthiher_layout_slug() ); ?>
        </main>
    </main>
</div>
<?php get_footer();
