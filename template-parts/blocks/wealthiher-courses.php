<?php

$course_posts = new WP_Query( array(
	'post_type' => WH_COURSES_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

if ( $course_posts->have_posts() ):

?>
<div class="splide courses-carousel is-style-fluid">
    <div class="splide__track">
        <ul class="splide__list">
			<?php while ( $course_posts->have_posts() ): $course_posts->the_post(); ?>
                <li class="splide__slide">
                    <div class="course">
                        <div class="image">
                            <?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                        </div>
                        <div class="details">
                            <h3 class="name"><?php the_title(); ?></h3>
                            <div class="categories">
                                <span class="button button-default"><?php echo get_post_meta( get_the_ID(), 'wh_course_time', true ); ?></span>
                                <?php foreach ( wp_get_post_terms( get_the_ID(), 'wh_course_theme' ) as $term ): ?><span class="button button-default"><?= $term->name ?></span><?php endforeach; ?>
                            </div>
                            <div class="excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="link button button-primary">Begin Course</a>
                    </div>
                </li>
			<?php endwhile; ?>
        </ul>
    </div>
    <div class="splide__arrows">
        <button class="splide__arrow splide__arrow--prev">←</button>
        <button class="splide__arrow splide__arrow--next">→</button>
    </div>
</div>
<?php

endif; 

wp_reset_postdata();