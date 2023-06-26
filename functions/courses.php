<?php

define( 'WH_COURSES_POST_TYPE_ID', 'wh_course' );

wh_action( 'init', 'courses' );

/**
 * @return void
 */
function wealthiher_action_init_courses() {

	register_post_type( WH_COURSES_POST_TYPE_ID, array(
		'labels'             => wh_post_type_labels( 'Course', 'Courses' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'courses' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-book-alt',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	) );

	// Register Partner's level taxonomy


	register_post_meta( WH_CHAMPIONS_POST_TYPE_ID, 'wh_course_time', array(
		'show_in_rest' => true,
		'single' => true,
		'type' => 'integer',
	) );

	register_block_type( 'wealthiher/courses', array( 'render_callback' => 'wealthiher_courses_callback' ) );
}

function wealthiher_courses_callback( array $attributes, string $content, WP_Block $block_instance ) {

	ob_start();
	get_template_part( 'template-parts/blocks/wealthiher-courses' );
	return ob_get_clean();
}
