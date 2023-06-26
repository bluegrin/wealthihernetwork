<?php

define( 'WH_ENVIRONMENT', defined( 'THEME_ENV' ) ? THEME_ENV : 'production' );
define( 'WH_THEME_VERSION', ( 'production' == WH_ENVIRONMENT ) ? wp_get_theme()->Version : time() );
define( 'WH_PLUGIN_ACTIVE_MEMBERPRESS', defined( 'MEPR_PLUGIN_NAME' ) && 'memberpress' == MEPR_PLUGIN_NAME );
define( 'WH_PLUGIN_ACTIVE_GRAVITY_FORMS', class_exists( 'GFCommon' ) );

define( 'WH_MAIN_THEME_ASSETS', array(

    // Main theme CSS
    array(
        'type' => 'style',
        'handle' => 'wealthiher',
        'src' => get_stylesheet_directory_uri() . '/assets/main.css',
        'deps' => array( 'wp-block-library' ),
    ),

    // Main theme JavaScript/jQuery
    array(
        'type' => 'script',
        'handle' => 'wealthiher',
        'src' => get_stylesheet_directory_uri() . '/assets/main.js',
        'deps' => array( 'jquery', 'splide' ),
        'localize' => true,
    ),

    // Splide
    array(
        'type' => 'script',
        'handle' => 'splide',
        'src' => 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js',
    ),

) );

const WH_PAGE_TEMPLATE_GATED = 'page-templates/gated.php';
const WH_PAGE_TEMPLATE_ONBOARDING = 'page-templates/onboarding.php';
const WH_PAGE_TEMPLATE_REGISTRATION = 'page-templates/registration.php';

// Require wrappers and shorthands
require_once 'functions/wrappers.php';

// Require classes
require_once 'inc/class-wealthiher-walker-nav-menu-header.php';
require_once 'inc/class-wealthiher-walker-nav-menu-footer.php';
require_once 'inc/class-wealthiher-walker-nav-menu-social.php';
require_once 'inc/class-wealthiher-walker-nav-menu-secondary.php';

// Require blocks
require_once 'functions/blocks/core-image.php';
require_once 'functions/blocks/core-group.php';

// Require functions
require_once 'functions/login.php';
require_once 'functions/register.php';
require_once 'functions/social.php';
require_once 'functions/partners.php';
require_once 'functions/testimonials.php';
require_once 'functions/experts.php';
require_once 'functions/team.php';
require_once 'functions/gravity-forms.php';
require_once 'functions/memberpress.php';

// Add filter callbacks
wh_filter( 'wp_nav_menu_objects', null, 10, 2 );
wh_filter( 'body_class' );
wh_filter( 'gettext', null, 10, 3 );

// Add action callbacks
wh_action( 'init' );
wh_action( 'admin_init' );
wh_action( 'wp_enqueue_scripts' );
wh_action( 'admin_enqueue_scripts' );
wh_action( 'after_setup_theme' );

function wealthiher_action_init() {

	$page_meta = array(
		'wh_title' => 'string',
		'wh_subtitle' => 'string',
		'wh_header_color' => 'string',
		'wh_header_waves_top' => 'boolean',
		'wh_header_waves_bottom' => 'boolean',
		'wh_menu' => 'integer',
		'wh_menu_color' => 'string',
        'wh_instagram_feed' => 'boolean',
	);

	foreach ( $page_meta as $meta_key => $type ) {
		register_post_meta( '', $meta_key, array(
			'show_in_rest' => true,
			'single' => true,
			'type' => $type,
		) );
	}

    add_shortcode( 'avatar_form', function () {
        get_template_part( 'template-parts/avatar-form' );
    } );
}

function wealthiher_action_admin_init() {

    add_theme_support( 'editor-styles' );
    add_editor_style( 'build/main.css' );
}

function wealthiher_action_wp_enqueue_scripts() {

	$main_theme_assets = WH_MAIN_THEME_ASSETS;

    // Vimeo
    if ( is_single() && 'mpcs-lesson' == get_post_type() ) {
        $main_theme_assets[] = array(
            'type' => 'script',
            'handle' => 'vimeo',
            'src' => 'https://player.vimeo.com/api/player.js',
        );
    }

	/**
	 * @todo Filter explanation
	 */
	$assets = apply_filters( 'wealthiher_wp_enqueue_scripts', $main_theme_assets );

    wh_enqueue( $assets );
}

function wealthiher_action_admin_enqueue_scripts() {

    $args = require_once 'build/main.asset.php';

	$main_theme_assets = array(

		// Gutenberg editor
		array(
			'type' => 'script',
			'handle' => 'gutenberg',
			'src' => get_template_directory_uri() . '/build/main.js',
			'deps' => array( 'wp-edit-post', 'wp-element', 'wp-components', 'wp-plugins', 'wp-data' ),
            'ver' => $args['version'],
		),

	);

	/**
	 * @todo Filter explanation
	 */
	$assets = apply_filters( 'wealthiher_admin_enqueue_scripts', $main_theme_assets );

	wh_enqueue( $assets );
}

function wealthiher_action_after_setup_theme() {

    register_nav_menus( array(
        'ungated_header_primary_menu' => __wh( 'Ungated Primary Header Menu (Bottom)' ),
        'ungated_header_secondary_menu' => __wh( 'Ungated Secondary Header Menu (Top)' ),
	    'ungated_footer_menu' => __wh( 'Ungated Footer Menu' ),
        'gated_header_menu' => __wh( 'Gated Header Menu' ),
        'gated_footer_menu' => __wh( 'Gated Footer Menu' ),
	    'social_media_menu' => __wh( 'Social Media Links' ),
    ) );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

    add_image_size( 'wh-gated-header-event', 326, 93 );
    add_image_size( 'wh-sponsor-partner-photo', 86, 86, true );
    add_image_size( 'wh-sponsor-partner-logo', 86, 28 );

    add_image_size( 'wh-lesson-card', 695, 285, true );
    add_image_size( 'wh-lesson-bottom-nav', 300, 75, true );
    add_image_size( 'wh-lesson-side-nav', 119, 153, true );

	$stylesheet = get_stylesheet_directory() . '/source/style/_palette.scss';

	if ( file_exists( $stylesheet ) ) {

		preg_match(  '/\/\* BEGIN SWATCHES \*\/[\r\n]([\s\S]*[\s\S])\/\* END SWATCHES \*\//m', file_get_contents( $stylesheet ), $matches );
		preg_match_all( '/\$swatch-(.*): (#.*);/m', $matches[1], $swatches, PREG_SET_ORDER );

		$args = array();

		foreach ( $swatches as $swatch ) {
			$args[] = array( 'name' => __wh( mb_convert_case( str_replace( '-', ' ', $swatch[1] ), MB_CASE_TITLE ) ), 'slug' => $swatch[1], 'color' => $swatch[2] );
		}

		add_theme_support( 'editor-color-palette', $args );
	}

    add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );
}

/**
 * @param array|WP_Post[] $sorted_menu_items
 * @param stdClass $args
 *
 * @return array
 */
function wealthiher_filter_wp_nav_menu_objects( array $sorted_menu_items, stdClass $args ) {

    $theme_location = $args->theme_location ?? null;

	if ( 'ungated_footer_menu' == $theme_location || 'gated_footer_menu' == $theme_location ) {

		$object_vars = (object) array(
			'ID' => -1,
			'post_name' => 'social-media-menu',
			'current' => false,
			'title' => 'Social Media',
		);

		$sorted_menu_items[] = new WP_Post( $object_vars );

	}

	return $sorted_menu_items;
}

/**
 * @param string[] $classes
 *
 * @return string[]
 */
function wealthiher_filter_body_class( array $classes ) {

    $layout_class = sprintf( 'layout-%s', wealthiher_layout_slug() );

    return array_merge( $classes, array( $layout_class ) );
}

function wealthiher_filter_gettext( $translation, $text, $domain ) {

    $localizations = array(
        'default' => array(
            'Username or Email Address' => 'Email',
            'Log In' => 'Login',
            'Lost your password?' => 'Forgot password?',
            'Get New Password' => 'Reset Password',
            'Log in' => '←Back to log in',
        ),
        'memberpress-courses' => array(
        ),
    );

    if ( array_key_exists( $domain, $localizations ) && array_key_exists( $text, $localizations[ $domain ] ) ) {
        return $localizations[ $domain ][ $text ];
    }

    return $translation;
}

function wealthiher_page_template( string $template_slug, int|WP_Post $wp_post ): bool {

    if ( $template_slug == get_page_template_slug( $wp_post ) ) {
        return true;
    }

    if ( $wp_post instanceof WP_Post && 0 != $wp_post->post_parent && wealthiher_page_template( $template_slug, $wp_post->post_parent ) ) {
        return true;
    }

    return false;
}

/**
 * @return string
 */
function wealthiher_layout_slug(): string {

    if ( is_user_admin() && isset( $_GET['layout'] ) ) {

        $layout_override = $_GET['layout'] ?? 'ungated';

        if ( in_array( $layout_override, array( 'ungated', 'gated', 'onboarding' ) ) ) {
            return  $layout_override;
        }

    }

    $layout_slug = 'ungated';

    global $post;

    if ( $post instanceof WP_Post ) {

        if ( wealthiher_page_template( WH_PAGE_TEMPLATE_GATED, $post ) ) {
            $layout_slug = 'gated';
        }

        if ( wealthiher_page_template( WH_PAGE_TEMPLATE_ONBOARDING, $post ) ) {
            $layout_slug = 'onboarding';
        }

        if ( wealthiher_page_template( WH_PAGE_TEMPLATE_REGISTRATION, $post ) ) {
            $layout_slug = 'onboarding';
        }

        if ( is_user_logged_in() && in_array( $post->post_type, array(
                'mpcs-course',
                'mpcs-lesson',
                'mpcs-quiz',
                'tribe_events'
            ) ) ) {
            $layout_slug = 'gated';
        }

        if ( 'memberpressproduct' == $post->post_type ) {
            $layout_slug = 'onboarding';
        }

    }

    if ( is_404() ) {
        $layout_slug = is_user_logged_in() ? 'gated' : 'ungated';
    }

    return apply_filters( 'wealthiher_layout_slug', $layout_slug, $post );
}

add_filter( 'tribe_events_integrations_should_load_freemius', '__return_false' );
