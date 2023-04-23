<?php

class Wealthiher_Walker_Nav_Menu_Header extends Walker_Nav_Menu {

	/**
	 * @var array|WP_Post[] An array of elements.
	 */
	protected $elements;

	/**
	 * @var int The maximum hierarchical depth.
	 */
	protected $max_depth;

	/**
	 * @var mixed Optional additional arguments.
	 */
	protected $args;

	/**
	 * @var array //TODO: Property explanation
	 */
	protected $element_css_widths = array();
	
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
		
		if ( untrailingslashit( $data_object->url ) == home_url() ) {
			$classes[] = 'home';
			$title = sprintf( '<img src="%s" alt="%s" width="350" height="117">', wh_img_url( 'wealthiher-network-logo.png' ), $data_object->title );
		}
		
		$classes[] = $this->get_element_css_width( $data_object->ID );
		
		$class_attribute = ( count( $classes ) ) ? sprintf( ' class="%s"', implode( ' ', $classes ) ) : '';
		
		$output .= sprintf( '<li%s><a href="%s">%s</a>', $class_attribute, $data_object->url, $title );
    }

    /**
     * @inheritDoc
     */
    public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
        $output .= '</li>';
    }

	/**
	 * @inheritDoc
	 */
	public function walk( $elements, $max_depth, ...$args ) {
		
		$this->elements = $elements;
		$this->max_depth = $max_depth;
		$this->args = $args;
		
		return parent::walk( $elements, $max_depth, $args );
	}

	protected function get_element_css_width( $ID ) {
		
		if ( ! array_key_exists( $ID, $this->element_css_widths ) ) {

			$element_positions = array();
			$pointer_current_position = 'before_logo';

			foreach ( $this->elements as $element ) {

				if ( untrailingslashit( $element->url ) == home_url() ) {
					$pointer_current_position = 'after_logo';
					continue;
				}

				$element_positions[ $pointer_current_position ][] = $element;

			}

			$elements_before_logo = $element_positions['before_logo'] ?? array();
			$elements_after_logo = $element_positions['after_logo'] ?? array();
            
			foreach ( $elements_before_logo as $element ) {
				$this->element_css_widths[ $element->ID ] = 'before count-' . count( $elements_before_logo);
			}

			foreach ( $elements_after_logo as $element ) {
				$width = floor( 50 / count( $elements_after_logo ) );
				$this->element_css_widths[ $element->ID ] = 'after count-' . count( $elements_after_logo );
			}

		}
		
		return $this->element_css_widths[ $ID ] ?? '';
		
	}
}