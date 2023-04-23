<?php

wh_filter( 'pre_render_block', 'core_images', 10, 2 );

function wealthiher_filter_pre_render_block_core_images( string $pre_render = null, array $parsed_block = array() ) {

	if ( 'core/image' != $parsed_block['blockName'] ?? null ) {
		return $pre_render;
	}
	
	$shadow_color = $parsed_block['attrs']['shadowColor'] ?? null;
    $classes = $parsed_block['attrs']['className'] ?? '';
	
    $width = $parsed_block['attrs']['width'] ?? null;
    $height = $parsed_block['attrs']['height'] ?? null;
    $size = $parsed_block['attrs']['sizeSlug'] ?? 'full';
    $align = $parsed_block['attrs']['align'] ?? 'center';
    
    $attr = array();
    
    if ( ! is_null( $width ) && ! is_null( $height ) ) {
        
        $margin = 'display: block; margin-right: auto; margin-left: auto;';
        
        $attr['width'] = $width;
        $attr['height'] = $height;
        $attr['style'] = sprintf( 'width: %dpx; height: %dpx; %s', $width, $height, $margin );
        
    }
    
	$attachment = wp_get_attachment_image( $parsed_block['attrs']['id'], $size, false, $attr );
	$attachment_sizes = wp_get_attachment_metadata( $parsed_block['attrs']['id'] );
	$attachment_width = $attachment_sizes['width'];
	$attachment_height = $attachment_sizes['height'];
	
	$css = sprintf( 'style="aspect-ratio: %s / %s;"', $attachment_width, $attachment_height );
	
	if ( str_contains( $classes, 'is-style-shadow-top-left' ) && ! is_null( $shadow_color ) ) {
		return sprintf( '<figure class="%s block-image shadow-top-left" %s>%s<div class="img-shadow background-%s" %s></div></figure>', $classes, $css, $attachment, $shadow_color, $css );
	}
	
	if ( str_contains( $classes, 'is-style-shadow-bottom-left' ) && ! is_null( $shadow_color ) ) {
		return sprintf( '<figure class="%s block-image shadow-bottom-left" %s>%s<div class="img-shadow background-%s" %s></div></figure>', $classes, $css, $attachment, $shadow_color, $css );
	}
	
	if ( str_contains( $classes, 'is-style-shadow-bottom-right' ) && ! is_null( $shadow_color ) ) {
		return sprintf( '<figure class="%s block-image shadow-bottom-right" %s>%s<div class="img-shadow background-%s" %s></div></figure>', $classes, $css, $attachment, $shadow_color, $css );
	}
	
	return sprintf( '<figure class="%s block-image">%s</figure>', $classes, $attachment );
}