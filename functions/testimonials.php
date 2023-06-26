<?php

define( 'WH_TESTIMONIALS_POST_TYPE_ID', 'wh_testimonial' );

wh_action( 'init', 'testimonials' );

/** 
 * @return void
 */
function wealthiher_action_init_testimonials() {

	register_post_type( WH_TESTIMONIALS_POST_TYPE_ID, array(
		'labels'             => wh_post_type_labels( 'Testimonial', 'Testimonials' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-testimonial',
		'supports'           => array( 'title', 'editor', 'excerpt' ),
	) );

	register_block_type( 'wealthiher/testimonials', array( 'render_callback' => 'wealthiher_testimonials_callback' ) );
}

function wealthiher_testimonials_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'template-parts/blocks/wealthiher-wealthiher-testimonials' );
	return ob_get_clean();
}

wh_add_post_type_meta( WH_TESTIMONIALS_POST_TYPE_ID, array(
    'details' => array(
        'title' => __wh( 'Reviewer' ),
        'context' => 'side',
        'fields' => array(
            array(
                'id' => 'name',
                'label' => __wh( 'Name' ),
            ),
            array(
                'id' => 'position',
                'label' => __wh( 'Position' ),
            ),
        ),
    ),
) );

