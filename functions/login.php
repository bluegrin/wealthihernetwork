<?php

// Filter hooks
wh_filter( 'login_body_class' );
wh_filter( 'login_headerurl' );
wh_filter( 'login_headertext' );
wh_filter( 'login_message' );
wh_filter( 'esc_html', null, 10, 2 );
wh_filter( 'login_link_separator' );
wh_filter( 'register' );
wh_filter( 'login_site_html_link' );
wh_filter( 'login_display_language_dropdown' );
wh_filter( 'network_site_url', null, 10, 3 );
wh_filter( 'wp_nav_menu_objects', 'login', 10, 2 );

// Action hooks
wh_action( 'login_enqueue_scripts' );
wh_action( 'login_header' );
wh_action( 'login_footer' );

/*
 * Filters
 */

function wealthiher_filter_login_body_class( $classes ) {
    $classes[] = 'layout-onboarding logo-icon';
    return $classes;
}

function wealthiher_filter_login_headerurl( $login_header_url ) {
    return '#';
}

function wealthiher_filter_login_headertext( $login_header_text ) {
    return sprintf( '<div class="welcome">%s<br><small>%s</small></div>', __wh( 'Welcome Back' ), __wh( 'Take control of your financial future, today.' ) );
}

function wealthiher_filter_login_message( $message ) {
    
    global $action;
    
    if ( 'lostpassword' === $action ) {
        return sprintf( '<div class="message"><h2>%s</h2><p>%s</p></div>', __wh( 'Forgot Password?' ), __wh( 'We’ll send you reset instructions.' ) );
    }
    
    return $message;
}

function wealthiher_filter_esc_html( $safe_text, $text ) {
    return '<br>' === $text ? $text : $safe_text;
}

function wealthiher_filter_login_link_separator( $value ) {
    return '<br>';
}

function wealthiher_filter_register( $registration_url ) {
    return sprintf( '<span class="register">%s <a href="%s">%s</a></span>', __wh( 'Don\'t have an account?' ), esc_url( wp_registration_url() ), __wh( 'Sign Up Now' ) );
}

function wealthiher_filter_login_site_html_link( $html_link ) {
    return '';
}

function wealthiher_filter_login_display_language_dropdown( $value ) {
    echo false;
}

function wealthiher_filter_network_site_url( $url, $path, $scheme ) {
    return ( in_array( $scheme, array( 'login', 'login_post' ) ) ) ? site_url( $path, $scheme ) : $url;
}

function wealthiher_filter_wp_nav_menu_objects_login( $sorted_menu_items, $args ) {

    foreach ( $sorted_menu_items as $sorted_menu_item ) {
        if ( $sorted_menu_item instanceof  WP_Post && isset( $sorted_menu_item->url ) && '#logout' == $sorted_menu_item->url ) {
            $sorted_menu_item->url = esc_url( wp_logout_url() );
        }
    }
    
    return $sorted_menu_items;
}

/*
 * Actions
 */

function wealthiher_action_login_enqueue_scripts() {
    
    wh_enqueue( WH_MAIN_THEME_ASSETS );
    
    wp_dequeue_style( 'login' );
    wp_enqueue_style( 'dashicons' );
}

function wealthiher_action_login_header() {
    get_template_part( 'template-parts/site-header-onboarding', null, array( 'logo' => 'icon' ) );
}

function wealthiher_action_login_footer() {
    get_template_part( 'template-parts/site-footer' );
}
