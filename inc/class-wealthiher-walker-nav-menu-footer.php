<?php

class Wealthiher_Walker_Nav_Menu_Footer extends Walker_Nav_Menu {
	
    /**
     * @inheritDoc
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul>';
    }

    /**
     * @inheritDoc
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '</ul>';
    }

    /**
     * @inheritDoc
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {

	    if ( -1 == $data_object->ID && 'social-media-menu' == $data_object->post_name ) {

		    $output .= '<li>' . wp_nav_menu( array(
			    'echo' => false,
			    'theme_location' => 'social_media_menu',
			    'walker' => new Wealthiher_Walker_Nav_Menu_Social,
			    'container' => 'nav',
			    'container_class' => 'social-menu',
			    'items_wrap' => '<ul>%3$s</ul>',
		    ) );

	    } else {

		    $classes = array();

		    if ( $data_object->current ) {
			    $classes[] = 'current';
		    }

		    $title = $data_object->title;

		    $class_attribute = ( count( $classes ) ) ? sprintf( ' class="%s"', implode( ' ', $classes ) ) : '';

		    $output .= sprintf( '<li%s><a href="%s">%s</a>', $class_attribute, $data_object->url, $title );

	    }
    }

    /**
     * @inheritDoc
     */
    public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
        $output .= '</li>';
    }
}