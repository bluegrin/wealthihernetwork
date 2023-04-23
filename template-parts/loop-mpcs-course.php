<?php

get_template_part( 'template-parts/title', wealthiher_layout_slug(), array( 'title' => __wh( 'Academy Dashboard' ) ) );

if ( 'new' == $_GET['welcome'] ?? null && false !== get_option( 'wh_details_page' ) ) {

    $args = array(
        'heading' => __wh( 'Complete your account setup' ),
        'description' => __wh( 'Let us tailor your experience.' ),
        'button_label' => __wh( 'Add your details now →' ),
        'button_link' => get_permalink( get_option( 'wh_details_page' ) ),
    );

    get_template_part( 'template-parts/notice', wealthiher_layout_slug(), $args );
}

$memberpress_user = new MeprUser( get_current_user_id() );

$all_courses = get_posts( array(
    'post_type' => 'mpcs-course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
) );

$active_courses = array_filter( $all_courses, function( WP_Post $wp_post ) use ( $memberpress_user ) {

    $memberpress_course = new \memberpress\courses\models\Course( $wp_post->ID );

    $course_progress = (float) $memberpress_course->user_progress( get_current_user_id() );

    if ( ! MeprRule::is_locked_for_user( $memberpress_user, $wp_post ) && $course_progress > 0 && $course_progress < 100 ) {
        return true;
    }

    return false;
} );

$active_course_ids = array_map( function ( WP_Post $course ) {
    return $course->ID;
}, $active_courses );

$completed_courses = array_filter( $all_courses, function( WP_Post $wp_post ) use ( $memberpress_user ) {

    $memberpress_course = new \memberpress\courses\models\Course( $wp_post->ID );

    $course_progress = (float) $memberpress_course->user_progress( get_current_user_id() );

    if ( ! MeprRule::is_locked_for_user( $memberpress_user, $wp_post ) && 100 == $course_progress ) {
        return true;
    }

    return false;
} );

$completed_course_ids = array_map( function ( WP_Post $course ) {
    return $course->ID;
}, $completed_courses );

$continue_courses = new WP_Query( array(
    'post_type' => 'mpcs-course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post__in' => $active_course_ids,
) );

if ( count( $active_courses ) && $continue_courses->have_posts() ):

?>
<section id="continue">
    <h2><?php _ewh( 'Pick up where you left off' ); ?></h2>
    <?php get_template_part( 'template-parts/splide', null, array( 'query' => $continue_courses, 'template_part_slug' => 'template-parts/post', 'template_part_name' => 'mpcs-course-user' ) ); ?>
</section>
<?php

endif;

wp_reset_postdata();

$curated_courses = new WP_Query( array(
    'post_type' => 'mpcs-course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'order' => 'ASC',
    'post__not_in' => array_merge( $active_course_ids, $completed_course_ids ),
) );

if ( $curated_courses->have_posts() ):

?>
<section id="curated">
    <h2><?php _ewh( 'Courses curated for you' ); ?></h2>
    <?php get_template_part( 'template-parts/splide', null, array( 'query' => $curated_courses, 'template_part_slug' => 'template-parts/post', 'template_part_name' => 'mpcs-course' ) ); ?>
</section>
<?php

endif;

wp_reset_postdata();

$finished_courses = new WP_Query( array(
    'post_type' => 'mpcs-course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post__in' => $completed_course_ids,
) );

if ( count( $completed_courses ) && $finished_courses->have_posts() ):

?>
<section id="completed">
    <h2><?php _ewh( 'Completed Courses' ); ?></h2>
    <?php get_template_part( 'template-parts/splide', null, array( 'query' => $finished_courses, 'template_part_slug' => 'template-parts/post', 'template_part_name' => 'mpcs-course-user' ) ); ?>
</section>
<?php

endif;

wp_reset_postdata();

$events = tribe_get_events();

if ( ! empty( $events ) ):

?>
<section id="upcoming">
    <h2><?php _ewh( 'Upcoming events' ); ?></h2>
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ( $events as $event ): ?>
                <li class="splide__slide">
                    <?php get_template_part( 'template-parts/post', 'tribe_events', array( 'event' => $event ) ); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="splide__arrows">
            <button class="splide__arrow splide__arrow--prev">←</button>
            <button class="splide__arrow splide__arrow--next">→</button>
        </div>
    </div>
</section>
<?php

endif;
