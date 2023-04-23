<?php

$secondary_nav = get_post_meta( get_the_ID(), 'wh_menu', true );
$secondary_nav_color = get_post_meta( get_the_ID(), 'wh_menu_color', true );

$container_classes = array( 'secondary-nav' );

if ( $secondary_nav_color ) {
	$container_classes[] = 'has-background background-' . $secondary_nav_color;
}

if ( $secondary_nav ) {

	wp_nav_menu(
		array(
			'menu'            => $secondary_nav,
			'walker'          => new Wealthiher_Walker_Nav_Menu_Secondary,
			'container'       => 'nav',
			'container_class' => implode( ' ', $container_classes ),
			'container_id'    => 'secondary-nav-menu',
			'items_wrap'      => '<ul>%3$s</ul>',
		)
	);

}