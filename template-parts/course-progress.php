<?php

use memberpress\courses\models\Lesson;
use memberpress\courses\models\Quiz;

if ( is_single() && in_array( get_post_type(), array( Lesson::$cpt, Quiz::$cpt ) ) ):

$memberpress_lesson = new Lesson( get_the_ID() );

$memberpress_lesson = match ( get_post_type() ) {
    Lesson::$cpt => new Lesson( get_the_ID() ),
    Quiz::$cpt => new Quiz( get_the_ID() ),
};

$memberpress_course = $memberpress_lesson->course();

$course_progress = round( $memberpress_course->user_progress( get_current_user_id() ) );

?>
<aside class="course-progress">
<h4><?php echo $memberpress_course->post_title; ?></h4>
<div class="progress">
    <span class="progress-label"><?php echo $course_progress . '% ' . __wh( 'Completed' ); ?></span>
    <progress class="progress-bar value-<?php echo $course_progress; ?>" max="100" value="<?php echo $course_progress; ?>"></progress>
</div>
<?php

$all_lessons = array();

foreach ( $memberpress_course->sections() as $section ) {
    foreach ( $section->lessons() as $lesson ) {
        $all_lessons[] = $lesson;
    }
}

$all_lessons[] = 'complete';

/** @var Lesson[]|Quiz[]|string[] $navigator_lessons */
$navigator_lessons = array();

for ( $i = 0; $i < count( $all_lessons ); $i++ ) {
    if ( $memberpress_lesson->ID == $all_lessons[$i]->ID ) {
        foreach ( array( 0, 1, 2, 3 ) as $n ) {
            $k = $i + $n;
            if ( array_key_exists( $k, $all_lessons ) ) {
                $navigator_lessons[] = $all_lessons[ $k ];
            }
        }
    }
}

if ( count( $navigator_lessons ) ): ?>
<ul class="navigator-lessons">
    <?php foreach ( $navigator_lessons as $lesson ): ?>
    <li class="navigator-lesson">
        <a <?php if ( 'complete' !== $lesson ): ?>href="<?php echo get_the_permalink( $lesson->ID ); ?>"<?php endif; ?>>
            <div class="thumbnail">
                <?php

                $thumbnail = '';

                if ( 'complete' === $lesson ) {

                    $thumbnail = sprintf( '<img src="%s" alt="%s" width="77" height="99">', get_stylesheet_directory_uri() . '/img/' . 'lesson-complete-side.png', __wh( 'Course Complete!' ) );

                } else {

                    if ( has_post_thumbnail( $lesson->ID ) ) {
                        $thumbnail = get_the_post_thumbnail( $lesson->ID, 'wh-lesson-side-nav' );
                    }

                    $side_nav_image_id = get_post_meta( $lesson->ID, 'sidebar_nav_image', true );

                    if ( ! empty( $side_nav_image_id ) ) {
                        $thumbnail = wp_get_attachment_image( $side_nav_image_id, 'wh-lesson-side-nav' );
                    }

                    if ( empty( $thumbnail ) ) {
                        $thumbnail = sprintf( '<img src="%s" alt="%s" width="77" height="99">', get_stylesheet_directory_uri() . '/img/' . 'lesson-complete-side.png', __wh( 'Coming Soon!' ) );
                    }

                }

                echo $thumbnail;

                ?>
            </div>
            <div class="title"><?php echo 'complete' === $lesson ? __wh( 'Course Complete!' ) : $lesson->post_title ?></div>
            <?php

            if ( 'complete' === $lesson ) {
                $name = 'complete';
            } else if ( Quiz::$cpt == $lesson->post_type ) {
                $name = 'activity';
            } else {
                $lesson_type = wp_get_post_terms( $lesson->ID, 'lesson_type', array( 'fields' => 'slugs') )[0];
                $name = match ( $lesson_type ) {
                    'masterclass' => 'video',
                    'reflect-act' => 'activity',
                    'read-more' => 'guide',
                    default => '',
                };
            }

            ?>
            <div class="icon <?php echo $name; ?>">
                <?php echo wh_svg_markup( sprintf( 'lesson-type-%s.svg', $name ) ); ?>
            </div>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<a href="<?php echo get_the_permalink( $memberpress_course->ID ); ?>" class="view-more"><?php _ewh( 'View More' ); ?></a>
<?php endif; ?>
</aside>
<?php endif;
