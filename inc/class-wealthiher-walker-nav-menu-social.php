<?php

class Wealthiher_Walker_Nav_Menu_Social extends Walker_Nav_Menu {
	
	private const SOCIAL_MEDIA_PLATFORMS = array(
		'facebook',
		'twitter',
		'instagram',
		'tiktok',
		'youtube',
		'linkedin',
	);
	
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
		
		$class_names = array();
		$icon = '';
		$label = $data_object->title;

	    foreach ( $data_object->classes as $class_name ) {
		    if ( str_starts_with( $class_name, 'menu-item' ) ) {
				continue;
		    }
			
			if ( in_array( $class_name, self::SOCIAL_MEDIA_PLATFORMS ) ) {
				$icon = sprintf( '<i class="fa-brands fa-%s"></i>', $class_name );
				$label = sprintf( '<span class="sr-only">%s</span>', $data_object->title );
				continue;
			}
			
			$class_names[] = $class_name;
		}
		
		$class = ( count( $class_names ) ) ? sprintf( ' class="%s"', implode( ' ', $class_names ) ) : '';
		
		$output .= sprintf( '<li%s><a href="%s" target="_blank" title="%s">%s%s</a>', $class, $data_object->url, $data_object->title, $icon, $label );
    }

    /**
     * @inheritDoc
     */
    public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
        $output .= '</li>';
    }
}