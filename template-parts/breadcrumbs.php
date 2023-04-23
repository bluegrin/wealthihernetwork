<?php if ( is_single() && in_array( get_post_type(), array( 'mpcs-course', 'mpcs-lesson', 'mpcs-quiz' ) ) ): ?>
<nav class="academy-breadcrumbs">
    <a href="/academy" class="academy-breadcrumb gray"><?php _ewh( 'Dashboard' ); ?></a>
    <?php

    if ( 'mpcs-course' == get_post_type() ) {

        $course = new \memberpress\courses\models\Course( get_the_ID() );

        echo '<span class="divider"></span>';
        printf( '<span class="academy-breadcrumb gray">%s</span>', $course->post_title );

    }

    if ( 'mpcs-lesson' == get_post_type() ) {

        $lesson = new \memberpress\courses\models\Lesson( get_the_ID() );
        $course = $lesson->course();

        echo '<span class="divider"></span>';
        printf( '<a href="%s" class="academy-breadcrumb gray">%s</a>', get_the_permalink( $course->ID ), $course->post_title );
        echo '<span class="divider"></span>';
        printf( '<span class="academy-breadcrumb">%s</span>', $lesson->post_title );
    }

    if ( 'mpcs-quiz' == get_post_type() ) {

        $quiz = new \memberpress\courses\models\Quiz( get_the_ID() );
        $course = $quiz->course();

        echo '<span class="divider"></span>';
        printf( '<a href="%s" class="academy-breadcrumb gray">%s</a>', get_the_permalink( $course->ID ), $course->post_title );
        echo '<span class="divider"></span>';
        printf( '<span class="academy-breadcrumb">%s</span>', $quiz->post_title );
    }

    ?>
</nav>
<?php endif; ?>
