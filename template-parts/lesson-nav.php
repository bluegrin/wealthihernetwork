<?php use memberpress\courses\models\Quiz;

if ( is_single() && in_array( get_post_type(), array( 'mpcs-lesson', 'mpcs-quiz' )) ): ?>
<?php

$item = match ( get_post_type() ) {
    \memberpress\courses\models\Lesson::$cpt => new \memberpress\courses\models\Lesson( get_the_ID() ),
    Quiz::$cpt => new Quiz( get_the_ID() ),
};

$items = $item->section()->lessons();

$completed = 0;

foreach ( $items as $other_item ) {
    if ( $other_item->is_complete() ) {
        $completed++;
    }
}

$percentage = round( $completed / count( $items ) * 100 );

$items[] = 'complete';

$prev_item = null;
$next_item = null;

for ( $i = 0; $i < count( $items ); $i++ ) {
    if ( $item->ID == $items[$i]->ID ) {

        $prev_item_index = $i - 1;
        $next_item_index = $i + 1;

        $prev_item = $items[$prev_item_index] ?? null;
        $next_item = $items[$next_item_index] ?? null;

    }
}

?>
<div class="complete-button-container">
    <?php if ( $item->is_complete() ): ?>
        <button type="button" class="complete-button" disabled><?php _ewh( 'Complete' ); ?></button>
    <?php else: ?>
        <button type="button" id="next_lesson_link" class="complete-button" data-value="<?php echo get_the_ID(); ?>" data-href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php _ewh( 'Mark as Complete' ); ?></button>
    <?php endif; ?>
</div>
<nav class="lesson-nav">
    <div class="prev">
        <?php if ( is_null( $prev_item ) ): ?>
        <?php wh_smart_arrow( 'left', array( 'disabled', 'fill-gray' ) ); ?>
        <?php else: ?>
        <?php

        if ( Quiz::$cpt == $prev_item->post_type ) {
            $label = __wh( 'Reflect & Act' );
        } else {
            $lesson_type = wp_get_post_terms( $prev_item->ID, 'lesson_type' )[0];
            $label = $lesson_type instanceof WP_Term ? $lesson_type->name : '';
        }

        ?>
        <a href="<?php echo get_the_permalink( $prev_item->ID ); ?>" class="enabled">
            <div class="thumbnail">
                <?php

                $prev_thumbnail = '';

                if ( has_post_thumbnail( $prev_item->ID ) ) {
                    $prev_thumbnail = get_the_post_thumbnail( $prev_item->ID, 'wh-lesson-bottom-nav' );
                }

                $prev_bottom_nav_image_id = get_post_meta( $prev_item->ID, 'bottom_nav_image', true );

                if ( ! empty( $prev_bottom_nav_image_id ) ) {
                    $prev_thumbnail = wp_get_attachment_image( $prev_bottom_nav_image_id, 'wh-lesson-bottom-nav' );
                }

                if ( empty( $prev_thumbnail ) ) {
                    $prev_thumbnail = sprintf( '<img src="%s" alt="%s" width="200" height="50">', get_stylesheet_directory_uri() . '/img/' . 'lesson-complete.png', __wh( 'Coming Soon!' ) );
                }

                echo $prev_thumbnail;

                ?>
            </div>
            <div class="nav">
                <?php wh_smart_arrow( 'left', array( 'fill-royal-blue' ) ); ?>
                <span><?php _ewh( 'Back:'); ?> <?php echo $label; ?></span>
            </div>
            <?php

            $lesson_type = wp_get_post_terms( get_the_ID(), 'lesson_type' )[0];
            $label = $lesson_type instanceof WP_Term ? $lesson_type->name : '';

            ?>
        </a>
        <?php endif; ?>
    </div>
    <div class="progress">
        <span class="progress-label"><?php echo $percentage . '% ' . __wh( 'Completed' ); ?></span>
        <progress class="progress-bar value-<?php echo $percentage; ?>" max="100" value="<?php echo $percentage; ?>"></progress>
    </div>
    <div class="next">
        <?php if ( is_null( $next_item ) ): ?>
        <?php wh_smart_arrow( 'right', array( 'disabled', 'fill-gray' ) ); ?>
        <?php else: ?>
        <?php

        $next_href = '';
        $next_thumbnail = '';
        $next_label = '';

        if ( 'complete' === $next_item ) {

            $next_href = get_the_permalink( $item->course()->ID );

            if ( 100 == $percentage ) {
                $next_href = add_query_arg( array( 'complete' => 'true' ), $next_href );
            }

            $next_thumbnail = sprintf( '<img src="%s" alt="%s" width="200" height="50">', get_stylesheet_directory_uri() . '/img/' . 'lesson-complete.png', __wh( 'Complete!' ) );

            $next_label = __wh( 'Complete' );

        } else {

            $next_href = get_the_permalink( $next_item->ID );

            if ( has_post_thumbnail( $next_item->ID ) ) {
                $next_thumbnail = get_the_post_thumbnail( $next_item->ID, 'wh-lesson-bottom-nav' );
            }

            $next_bottom_nav_image_id = get_post_meta( $next_item->ID, 'bottom_nav_image', true );

            if ( ! empty( $next_bottom_nav_image_id ) ) {
                $next_thumbnail = wp_get_attachment_image( $next_bottom_nav_image_id, 'wh-lesson-bottom-nav' );
            }

            if ( empty( $next_thumbnail ) ) {
                $next_thumbnail = sprintf( '<img src="%s" alt="%s" width="200" height="50">', get_stylesheet_directory_uri() . '/img/' . 'lesson-complete.png', __wh( 'Coming Soon!' ) );
            }

            if ( Quiz::$cpt == $next_item->post_type ) {
                $next_label = __wh( 'Reflect & Act' );
            } else {
                $lesson_type = wp_get_post_terms( $next_item->ID, 'lesson_type' )[0];
                $next_label = $lesson_type instanceof WP_Term ? $lesson_type->name : '';
            }

        }

        ?>
        <a href="<?php echo $next_href; ?>" class="enabled">
            <div class="thumbnail">
                <?php echo $next_thumbnail; ?>
            </div>
            <div class="nav">
                <span><?php _ewh( 'Next:'); ?> <?php echo $next_label; ?></span>
                <?php wh_smart_arrow( 'right', array( 'fill-royal-blue' ) ); ?>
            </div>
        </a>
        <?php endif; ?>
    </div>
</nav>
<?php endif;
