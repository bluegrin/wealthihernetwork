<?php

class Wealthiher_Walker_Nav_Menu_Secondary extends Walker_Nav_Menu {
	
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

	    $classes = array();

	    if ( $data_object->current ) {
		    $classes[] = 'current';
	    }

	    $title = $data_object->title;

	    $class_attribute = ( count( $classes ) ) ? sprintf( ' class="%s"', implode( ' ', $classes ) ) : '';

	    $output .= sprintf( '<li%s><a href="%s">%s</a>', $class_attribute, $data_object->url, $title );
    }

    /**
     * @inheritDoc
     */
    public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
        $output .= '</li>';
    }
}