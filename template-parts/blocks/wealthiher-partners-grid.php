<?php

$partner_posts = get_posts( array(
	'post_type' => WH_PARTNERS_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

?>
<div class="partners-grid">
<?php foreach ( $partner_posts as $partner_post ): ?>
<?php printf( '<div class="logo">%s</div>', wp_get_attachment_image( get_post_thumbnail_id( $partner_post->ID ), 'full' ) ); ?>
<?php  endforeach; ?>
</div>