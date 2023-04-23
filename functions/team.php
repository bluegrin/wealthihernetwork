<?php

define( 'WH_TEAM_POST_TYPE_ID', 'wh_team' );

wh_action( 'init', 'team' );

/** 
 * @return void
 */
function wealthiher_action_init_team() {

	register_post_type( WH_TEAM_POST_TYPE_ID, array(
		'labels'             => wh_post_type_labels( 'Team Member', 'Team Members', 'Photo' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'team' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-admin-users',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	) );

	register_block_type( 'wealthiher/team', array( 'render_callback' => 'wealthiher_team_callback' ) );
}

function wealthiher_team_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'blocks/team/template' );
	return ob_get_clean();
}

wh_add_post_type_meta( WH_TEAM_POST_TYPE_ID, array(
    'details' => array(
        'title' => __wh( 'Details' ),
        'context' => 'side',
        'fields' => array(
            array(
                'id' => 'position',
                'label' => __wh( 'Position' ),
            ),
            array(
                'id' => 'linkedin',
                'label' => __wh( 'LinkedIn' ),
            ),
        ),
    ),
) );
