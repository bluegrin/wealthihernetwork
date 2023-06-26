<?php

$partner_posts = get_posts( array(
	'post_type' => WH_PARTNERS_POST_TYPE_ID,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
) );

$i = 1;
$j = 0;

$clusters = array();

foreach ( $partner_posts as $partner_post ) {
	
	$clusters[$j] .= sprintf( '<div class="logo">%s</div>', wp_get_attachment_image( get_post_thumbnail_id( $partner_post->ID ), 'full' ) );
	
	if ( 0 === $i % 4 ) {
		$j++;
	}
	
	$i++;
	
}



?>
<div class="splide partners-carousel">
	<div class="splide__track">
		<ul class="splide__list">
			<?php foreach ( $clusters as $cluster ): ?>
			<li class="splide__slide">
				<div class="cluster">
					<?php echo $cluster ?>
				</div>
			</li>
			<?php  endforeach; ?>
		</ul>
	</div>
</div>