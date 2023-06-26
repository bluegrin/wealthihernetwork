<?php

$partner_posts = get_posts( array(
	'post_type' => WH_PARTNERS_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

?>
<div class="splide partners-marquee is-style-fluid">
    <div class="marquee">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ( $partner_posts as $partner_post ): ?>
                <li class="splide__slide">
                <?php printf( '<div class="logo">%s</div>', wp_get_attachment_image( get_post_thumbnail_id( $partner_post->ID ), 'full' ) ) ?>
                </li>
                <?php  endforeach; ?>
            </ul>
        </div>
    </div>
    <svg width="1728" height="119.06596" viewBox="0 0 1728 119.06596" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="waves bottom">
        <path class="waves-path" d="M 0,0 V 84.005859 C 103.92682,117.90684 251.17475,140.64064 420.13281,87.269531 559.04667,43.388475 708.89687,48.614072 827.46875,67.001953 946.04063,85.389835 1091.641,87.270054 1238.3809,37.970703 1395.6899,-14.878304 1599.033,-1.8321511 1728,13.609375 V 0 Z" />
    </svg>
</div>
