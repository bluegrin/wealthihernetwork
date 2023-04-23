<?php

define( 'WH_PARTNERS_POST_TYPE_ID', 'wh_partner' );
define( 'WH_CHAMPIONS_POST_TYPE_ID', 'wh_champion' );

wh_action( 'init', 'partners' );
wh_action( 'save_post', 'partners', 10, 3 );
wh_action( 'after_setup_theme', 'partners' );

/**
 * Register Champions and Partners post types, partner level taxonomy, and Champion Partner meta
 * 
 * @return void
 */
function wealthiher_action_init_partners() {

	// Register Champions post type
	register_post_type( WH_CHAMPIONS_POST_TYPE_ID, array(
		'labels'             => wh_post_type_labels( 'Champion', 'Champions', 'Photo' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'champion' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-businessperson',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	) );

	// Register Partners post type
	register_post_type( WH_PARTNERS_POST_TYPE_ID, array(
		'labels'             => wh_post_type_labels( 'Partner', 'Partners', 'Logo' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'partner' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-bank',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	) );
	
	// Register Champion's partner taxonomy
	register_taxonomy( 'wh_partner', array( WH_CHAMPIONS_POST_TYPE_ID ), array(
		'hierarchical'      => true,
		'labels'            => wh_taxonomy_labels( 'Partner', 'Partners' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'level' ),
	) );

	// Register Partner's level taxonomy
	register_taxonomy( 'wh_level', array( WH_PARTNERS_POST_TYPE_ID ), array(
		'hierarchical'      => true,
		'labels'            => wh_taxonomy_labels( 'Level', 'Levels' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'level' ),
	) );

	register_post_meta( WH_CHAMPIONS_POST_TYPE_ID, 'wh_partner', array(
		'show_in_rest' => true,
		'single' => true,
		'type' => 'integer',
	) );
	
	register_block_type( 'wealthiher/partners-carousel', array( 'render_callback' => 'wealthiher_partners_carousel_callback' ) );
	register_block_type( 'wealthiher/partners-marquee', array( 'render_callback' => 'wealthiher_partners_marquee_callback' ) );
	register_block_type( 'wealthiher/partners-grid', array( 'render_callback' => 'wealthiher_partners_grid_callback' ) );
}

/**
 * Create a Champion's Partner term and link it to the Partners post type
 *
 * @param int $post_ID
 * @param WP_Post $wp_post
 * @param bool $update
 *
 * @return void
 */
function wealthiher_action_save_post_partners( int $post_ID, WP_Post $wp_post, bool $update ) {
	
	if ( WH_PARTNERS_POST_TYPE_ID != $wp_post->post_type ) {
		return;
	}
	
	if ( $update ) {
		
		$term_id = get_post_meta( $post_ID, 'wh_partner_term_id', true );
		
		if ( ! $term_id ) {

			$data = wp_insert_term( $wp_post->post_title, 'wh_partner', array(
				'slug' => $wp_post->post_name,
			) );

		} else {

			$data = wp_update_term( $term_id, 'wh_partner', array(
				'name' => $wp_post->post_title,
				'slug' => $wp_post->post_name,
			) );

		}
		
	} else {
		
		$data = wp_insert_term( $wp_post->post_title, 'wh_partner', array(
			'slug' => $wp_post->post_name,
		) );
		
	}

	if ( ! $data instanceof WP_Error ) {

		$term_id = $data[ 'term_id' ];

		update_term_meta( $term_id, 'wh_partner_post_id', $post_ID );
		update_post_meta( $post_ID, 'wh_partner_term_id', $term_id );

	}
}

function wealthiher_action_after_setup_theme_partners() {
	
	add_image_size( 'wh-champion', 170, 260, true );
}

function wealthiher_partners_carousel_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'blocks/partners-carousel/template' );
	return ob_get_clean();
}

function wealthiher_partners_marquee_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'blocks/partners-marquee/template' );
	return ob_get_clean();
}

function wealthiher_partners_grid_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'blocks/partners-grid/template' );
	return ob_get_clean();
}