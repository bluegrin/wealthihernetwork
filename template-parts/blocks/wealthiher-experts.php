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
<div class="splide experts-carousel is-style-fluid">
    <div class="splide__arrows">
        <button class="splide__arrow splide__arrow--prev">←</button>
        <button class="splide__arrow splide__arrow--next">→</button>
    </div>
    <div class="splide__track">
        <ul class="splide__list">
			<?php while ( $expert_posts->have_posts() ): $expert_posts->the_post(); ?>
                <li class="splide__slide">
                    <div class="expert" style="background-image: url(<?= get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?> );">
                        <div class="details">
                            <div class="person">
                                <div class="name"><?php the_title(); ?></div>
                                <div class="position"><?php wh_the_post_meta( get_the_ID(), 'association' ); ?></div>
                            </div>
                            <div class="button-container">
                                <a href="<?php wh_the_post_meta( get_the_ID(), 'link' ); ?>" class="button button-secondary">Learn More</a>
                            </div>
                        </div>
                    </div>
                </li>
			<?php endwhile; ?>
        </ul>
    </div>
</div>
<?php

endif; 

wp_reset_postdata();