<?php

define( 'WH_EXPERTS_POST_TYPE_ID', 'wh_expert' );
define( 'WH_EXPERTS_WEBSITE_ID', 'wh_expert_website' );
define( 'WH_EXPERTS_LINKEDIN_ID', 'wh_expert_linkedin' );

wh_action( 'init', 'experts' );

/** 
 * @return void
 */
function wealthiher_action_init_experts() {

	register_post_type( WH_EXPERTS_POST_TYPE_ID, array(
		'labels'             => wh_post_type_labels( 'Expert', 'Experts', 'Photo' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'experts' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-awards',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	) );
	
	register_block_type( 'wealthiher/experts', array( 'render_callback' => 'wealthiher_experts_callback' ) );
	register_block_type( 'wealthiher/experts-blinds', array( 'render_callback' => 'wealthiher_experts_blinds_callback' ) );
}

function wealthiher_experts_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'blocks/experts/template' );
	return ob_get_clean();
}

function wealthiher_experts_blinds_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'blocks/experts-blinds/template' );
	return ob_get_clean();
}

wh_add_post_type_meta( WH_EXPERTS_POST_TYPE_ID, array(
    'details' => array(
        'title' => __wh( 'Details' ),
        'context' => 'side',
        'fields' => array(
            array(
                'id' => 'association',
                'label' => __wh( 'Association' ),
            ),
            array(
                'id' => 'link',
                'label' => __wh( 'External Link' ),
            ),
        ),
    ),
) );
