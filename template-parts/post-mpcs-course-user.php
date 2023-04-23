<?php

$memberpress_course = new \memberpress\courses\models\Course( get_the_ID() );

$course_progress = $memberpress_course->user_progress( get_current_user_id() );

?>
<article class="course">
    <?php if ( $course_progress < 100 ): ?>
    <progress class="progress value-<?php echo $course_progress; ?>" max="100" value="<?php echo $course_progress; ?>"></progress>
    <?php endif; ?>
    <?php echo get_the_post_thumbnail( get_the_ID(), 'full' ) ?>
    <div class="meta">
        <h3 class="title"><?php the_title(); ?></h3>
        <div class="tags">
            <span class="tag"><?php echo get_post_meta( get_the_ID(), 'duration', true ); ?></span>
            <span class="tag dark"><?php echo $course_progress; ?>% <?php _ewh( 'Completed' ); ?></span>
        </div>
    </div>
    <?php if ( 100 == $course_progress ): ?>
    <a href="<?php echo add_query_arg( array( 'view' => 'action-point' ), get_the_permalink( get_the_ID() ) ); ?>" class="action-plan"><?php _ewh( 'View your Action Plan' ); ?> →</a>
    <?php endif; ?>
    <a href="<?php the_permalink(); ?>" class="cta"><?php _ewh( 100 == $course_progress ? 'Restart Course' : 'Continue Learning' ); ?> →</a>
</article>
