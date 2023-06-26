<?php

$team_posts = new WP_Query( array(
	'post_type' => WH_TEAM_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

if ( $team_posts->have_posts() ):

?>
<div class="team">
    <ul>
        <?php while ( $team_posts->have_posts() ): $team_posts->the_post(); ?>
        <li class="team-member">
            <figure class="photo">
                <?php the_post_thumbnail( 'full' ); ?>
                <a href="<?php echo get_post_meta( get_the_ID(), 'wh_team_linkedin', true ); ?>" class="social"><span class="fab fa-linkedin"></span></a>
            </figure>
            <div class="position"><?php echo get_post_meta( get_the_ID(), 'wh_team_position', true ) ?></div>
            <div class="name"><?php the_title(); ?></div>
        </li>
        <?php endwhile; ?>
        <li class="team-join">
            <div class="photo">
                <h3><?= __wh( 'Join our team' ) ?></h3>
                <p><?= __wh( 'Want to be a part of something great?' ) ?></p>
            </div>
        </li>
    </ul>
</div>
<?php

endif; 

wp_reset_postdata();