<?php

$testimonial_posts = new WP_Query( array(
	'post_type' => WH_TESTIMONIALS_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

if ( $testimonial_posts->have_posts() ):

?>
<div class="splide testimonials-carousel">
    <div class="splide__track">
        <ul class="splide__list">
			<?php while ( $testimonial_posts->have_posts() ): $testimonial_posts->the_post(); ?>
                <li class="splide__slide">
                    <div class="testimonial">
                        <div class="quote">
                            <div class="open-quote"></div>
                            <?php the_content(); ?>
                            <div class="close-quote"></div>
                        </div>
                        <div class="author">
                            <strong><?php wh_the_post_meta( get_the_ID(), 'name' ); ?></strong><br><?php wh_the_post_meta( get_the_ID(), 'position' ); ?>
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