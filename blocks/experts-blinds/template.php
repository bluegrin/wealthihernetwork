<?php

$expert_posts = new WP_Query( array(
	'post_type' => WH_EXPERTS_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

if ( $expert_posts->have_posts() ):
    
?>
<div class="experts-blinds is-style-fluid">
    <?php $i = 1; while ( $expert_posts->have_posts() ): $expert_posts->the_post(); ?>
    <div class="expert<?= 1 != $i ? ' closed' : '' ?> expert-<?= get_post_field( 'post_name' ) ?>" style="background-image: url(<?= get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?> );">
        <div class="details">
            <div class="person">
                <div class="name"><?php the_title(); ?></div>
                <div class="position"><?php wh_the_post_meta( get_the_ID(), 'association' ); ?></div>
            </div>
            <div class="button-container">
                <a href="<?php wh_the_post_meta( get_the_ID(),  'link' ); ?>" class="button button-secondary" target="_blank">Learn More</a>
            </div>
        </div>
    </div>
    <?php $i++; endwhile; ?>
</div>
<?php

endif; 

wp_reset_postdata();