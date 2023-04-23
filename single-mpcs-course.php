<?php

$memberpress_course = new \memberpress\courses\models\Course( get_the_ID() );
$memberpress_user = new MeprUser( get_current_user_id() );

$first_opened = false;

$sections = array(
    'masterclass' => array(),
    'read-more' => array(),
    'reflect-act' => array(),
);

foreach ( $memberpress_course->lessons() as $memberpress_lesson ) {

    $wp_lesson = get_post( $memberpress_lesson->ID );

    $lesson_types = wp_get_post_terms( $wp_lesson->ID, 'lesson_type' );

    if ( $lesson_types[0] instanceof WP_Term ) {
        $sections[ $lesson_types[0]->slug ][] = $memberpress_lesson;
    }

    if ( $memberpress_lesson instanceof \memberpress\courses\models\Quiz ) {
        $sections['reflect-act'][] = $memberpress_lesson;
    }
}

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
        <?php if ( 'true' == $_GET['complete'] ?? 'false' && 100 == $memberpress_course->user_progress( MeprUtils::get_current_user_id()) ): ?>

        <div class="course-complete">
            <h1 class="complete"><?php printf( '%s, %s.', __wh( 'Course Complete! Well Done' ), get_user_meta( get_current_user_id(), 'first_name', true ) ); ?></h1>
            <p class="subheading"><?php printf( '%s &lsquo;%s&rsquo;', __wh( 'Well done on completing the course' ), $memberpress_course->post_title ) ?></p>
            <p><a href="<?php echo get_the_permalink( $memberpress_course->ID ); ?>" class="button course-overview"><?php _ewh( 'Go back to course overview' ); ?></a></p>
            <p><a href="/academy" class="button academy-dashboard"><?php _ewh( 'Return to dashboard' ); ?></a></p>
        </div>

        <?php

        $all_courses = get_posts( array(
            'post_type' => 'mpcs-course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ) );

        $active_courses = array_filter( $all_courses, function( WP_Post $wp_post ) use ( $memberpress_course, $memberpress_user ) {

            $course_progress = (float) $memberpress_course->user_progress( get_current_user_id() );

            if ( ! MeprRule::is_locked_for_user( $memberpress_user, $wp_post ) && 0 == $course_progress ) {
                return true;
            }

            return false;
        } );

        $active_course_ids = array_map( function ( WP_Post $course ) {
            return $course->ID;
        }, $active_courses );

        $curated_courses = new WP_Query( array(
            'post_type' => 'mpcs-course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'rand',
            'order' => 'ASC',
            'post__not_in' => $active_course_ids,
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

        ?>

        <?php elseif ( 'action-point' == $_GET['view'] ?? null ): ?>

        <h1><?php _ewh( 'Reflections & Action Points' ); ?></h1>

        <?php

        foreach ( $memberpress_course->quizzes() as $quiz ) {
            foreach ( \memberpress\courses\models\Question::get_all( '', '', array( 'quiz_id' => $quiz->ID ) ) as $question ) {

                $attempt = \memberpress\courses\models\Attempt::get_one( array( 'quiz_id' => $quiz->ID, 'user_id' => $memberpress_user->ID, 'status' => 'complete' ) );

                $answer = \memberpress\courses\models\Answer::get_one( array( 'attempt_id' => $attempt->id, 'question_id' => $question->id ) );

                printf( '<section class="reflection"><h3>%s</h3><div class="answer">%s</div></section>', $question->text, $answer->answer );

            }
        }

        ?>

        <?php else: ?>

        <?php get_template_part( 'template-parts/title', wealthiher_layout_slug() ); ?>
        <?php the_content(); ?>
        <ul class="sections">
            <?php foreach ( $sections as $section_name => $lessons ): ?>
            <?php

            $percentage = 0;

            if ( count( $lessons ) ) {

                $completed = 0;

                foreach ( $lessons as $lesson ) {
                    if ( $lesson->is_complete() ) {
                        $completed++;
                    }
                }

                $percentage = round( $completed / count( $lessons ) * 100 );

            }

            $class = $first_opened ? 'closed' : 'open';

            if ( 'open' == $class ) {
                $first_opened = true;
            }

            ?>
            <li class="section <?php echo $class; ?>">
                <header class="section-header">
                    <div class="details">
                        <h2 class="heading"><?php echo match ( $section_name ) { 'masterclass' => __wh( 'Masterclasses' ), 'read-more' => __wh( 'Inspiration & Resources' ), 'reflect-act' => __wh( 'Reflect & Act' ) }; ?></h2>
                        <?php if ( count( $lessons ) ): ?>
                        <span class="progress-label"><?php echo $percentage . '% ' . __wh( 'Completed' ); ?></span>
                        <progress class="progress-bar value-<?php echo $percentage; ?>" max="100" value="<?php echo $percentage; ?>"></progress>
                        <?php endif; ?>
                    </div>
                    <div class="toggle">
                        <button type="button" class="lessons-toggle">
                            <img src="<?= wh_img_url( 'accordion-close.svg' ) ?>" alt="" width="30" height="24">
                            <span class="sr-only">Toggle Section</span>
                        </button>
                    </div>
                </header>
                <div class="lessons" id="section-<?php echo $section_name ?>">
                    <div class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php foreach ( $lessons as $lesson ): ?>
                                <li class="splide__slide">
                                    <article class="lesson">
                                        <?php

                                        $thumbnail = '';

                                        if ( has_post_thumbnail( $lesson->ID ) ) {
                                            $thumbnail = get_the_post_thumbnail( $lesson->ID, 'wh-lesson-card' );
                                        }

                                        $card_image_id = get_post_meta( $lesson->ID, 'card_image', true );

                                        if ( ! empty( $card_image_id ) ) {
                                            $thumbnail = wp_get_attachment_image( $card_image_id, 'wh-lesson-card' );
                                        }

                                        if ( empty( $thumbnail ) ) {
                                            $thumbnail = sprintf( '<div class="thumbnail-placeholder">%s</div>', __wh( 'Coming Soon!' ) );
                                        }

                                        echo $thumbnail;

                                        ?>
                                        <div class="meta">
                                            <h3 class="title"><?php echo get_the_title( $lesson->ID ); ?></h3>
                                            <div class="tags">
                                                <?php if ( $duration = get_post_meta( $lesson->ID, 'duration', true ) ): ?>
                                                <span class="tag"><?php echo $duration; ?></span>
                                                <?php endif; ?>
                                                <span class="tag dark"><?php echo $lesson->is_complete() ? __wh( 'Complete' ) : __wh( 'Not Started' ); ?></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo get_the_permalink( $lesson->ID ); ?>" class="cta"><?php _ewh( 'Watch Now' ); ?> →</a>
                                    </article>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="splide__arrows">
                            <button class="splide__arrow splide__arrow--prev">←</button>
                            <button class="splide__arrow splide__arrow--next">→</button>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php endif; ?>
        </main>
    </main>
</div>
<?php get_footer();
