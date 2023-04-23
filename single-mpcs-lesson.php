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
            <?php $video_url = get_post_meta( get_the_ID(), 'video', true ); if ( $video_url ): ?>
            <div class="video">
                <iframe src="<?php echo $video_url ?>>" allow="fullscreen; picture-in-picture"></iframe>
            </div>
            <?php endif; ?>
            <div class="columns">
                <div class="left">
                    <div class="subheading"><?php echo get_post_meta( get_the_ID(), 'subtitle', true ); ?></div>
                    <div class="tags">
                        <?php foreach ( wp_get_post_terms( $lesson->course()->ID, 'mpcs-course-categories' ) as $category ): if ( $category instanceof WP_Term ): ?>
                        <span class="tag"><?php echo $category->name ?></span>
                        <?php endif; endforeach; ?>
                        <span class="tag"><?php echo get_post_meta( get_the_ID(), 'duration', true ); ?></span>
                    </div>
                    <?php if ( in_array( 'read-more', wp_get_post_terms( get_the_ID(), 'lesson_type', array( 'fields' => 'slugs' ) ) ) ): ?>
                    <div class="featured-image">
                        <?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="columns">
                <div class="left">
                    <div class="content">
                        <?php $wh_skip_callouts = true; the_content(); unset( $wh_skip_callouts ); ?>
                    </div>
                    <?php if ( count( wp_get_post_terms( get_the_ID(), 'lesson_sponsor' ) ) ): ?>
                    <div class="sponsors-partners">
                        <h2 class="heading"><?php _ewh( 'Sponsors & Partners' ); ?></h2>
                        <ul class="sponsors-partners-list">
                            <?php foreach ( wp_get_post_terms( get_the_ID(), 'lesson_sponsor' ) as $sponsor_partner ): if ( $sponsor_partner instanceof  WP_Term ): ?>
                            <li class="sponsor-partner">
                                <div class="images">
                                    <div class="photo">
                                        <?php echo wp_get_attachment_image( get_term_meta( $sponsor_partner->term_id, 'photo', true ), 'wp-sponsor-partner-photo' ); ?>
                                    </div>
                                    <div class="logo">
                                        <?php echo wp_get_attachment_image( get_term_meta( $sponsor_partner->term_id, 'logo', true ), 'wp-sponsor-partner-logo' ); ?>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="name"><?php echo $sponsor_partner->name; ?></div>
                                    <div class="company"><?php echo get_term_meta( $sponsor_partner->term_id, 'title', true ); ?></div>
                                    <div class="bio"><?php echo $sponsor_partner->description; ?></div>
                                </div>
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
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
