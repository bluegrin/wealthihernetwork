<?php

if ( file_exists( ABSPATH . '/debug.php' ) ) include_once ABSPATH . '/debug.php';

if ( ! WH_PLUGIN_ACTIVE_MEMBERPRESS ) {
    return;
}

wh_action( 'init', 'memberpress' );
wh_action( 'the_post', 'memberpress', 10, 2 );
wh_action( 'wp_enqueue_scripts', 'memberpress' );
wh_action( 'template_redirect', 'memberpress' );
wh_action( 'admin_footer', 'memberpress' );
wh_action( 'mepr-checkout-before-submit' );

wh_filter( 'wealthiher_layout_slug', 'memberpress', accepted_args: 2 );
wh_filter( 'mepr_is_account_page', accepted_args: 2 );
wh_filter( 'mepr_render_custom_fields' );
wh_filter( 'mepr-mailchimptags-add-subscriber-args' );
wh_filter( 'post_type_labels_memberpressgroup' );
wh_filter( 'body_class', 'memberpress' );

remove_filter_object( 'the_content', \memberpress\courses\controllers\Courses::class, 'page_router', 10 );
remove_filter_object( 'the_content', \memberpress\courses\controllers\Lessons::class, 'prepend_breadcrumbs', 10 );
remove_filter_object( 'the_content', \memberpress\courses\controllers\Lessons::class, 'append_lesson_navigation', 10 );
remove_filter_object( 'the_content', \memberpress\courses\controllers\Lessons::class, 'lesson_locked_message', 99 );
remove_filter_object( 'the_content', \memberpress\courses\controllers\Quizzes::class, 'append_quiz_navigation', 10 );

enum AccountControllerActions: string
{
    case Home = 'home';
    case Password = 'password';
    case Payments = 'payments';
    case Subscriptions = 'subscriptions';
    case Update = 'update';
}

/*
 * Actions
 */

function wealthiher_action_init_memberpress() {

    add_shortcode( 'wh_mepr_form', 'wealthiher_shortcode_memberpress_form' );

    register_block_type( 'wealthiher/memberpress-form', array( 'render_callback' => 'wealthiher_block_memberpress_form_callback' ) );

    register_taxonomy( 'lesson_type', array( 'mpcs-lesson-type' ), array(
        'hierarchical'      => true,
        'labels'            => wh_taxonomy_labels( 'Lesson Type', 'Lesson Types' ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'types' ),
    ) );

    register_taxonomy( 'lesson_sponsor', array( 'mpcs-lesson-type' ), array(
        'hierarchical'      => true,
        'labels'            => wh_taxonomy_labels( 'Lesson Sponsor', 'Lesson Sponsors' ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'sponsors' ),
    ) );

    $post_id = url_to_postid( 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] );

    if ( $post_id == WEALTHIHER_HAUTE_MEMBERSHIP_PRODUCT_ID ) {

        if ( isset( $_GET['app_id'] ) ) {

            $application_query_args = array(
                'meta_query' => array(
                    array(
                        'key' => 'haute_membership_application_hash',
                        'value' => $_GET['app_id'],
                    ),
                ),
            );

            $application_query = new WP_User_Query( $application_query_args );

            if ( count( $application_query->get_results() ) ) {

                /** @var WP_User $application_member */
                $application_member = $application_query->get_results()[0];

                $application_status = get_user_meta( $application_member->ID, 'haute_membership_application_status', true );

                if ( 'approved' == $application_status ) {

                    wp_set_auth_cookie( $application_member->ID );

                    set_transient( 'wealthiher_application_complete_allowed', 'true' );

                    wp_safe_redirect( get_the_permalink( WEALTHIHER_HAUTE_MEMBERSHIP_PRODUCT_ID ) );
                    exit;

                }

            }

        }

    }
}

function wealthiher_action_wp_enqueue_scripts_memberpress() {
    wp_dequeue_style( 'mp-theme' );
}

function wealthiher_action_template_redirect_memberpress() {

    $action = $_GET['action'] ?? null;
    $sub = $_GET['sub'] ?? null;

    $membership_page = get_option( 'wh_membership_page' );
    $billing_page = get_option( 'wh_billing_page' );

    if ( 'update' == $action && ! is_null( $sub ) && false !== $membership_page && false !== $billing_page && is_page( $membership_page ) ) {
        wp_redirect( add_query_arg( array( 'action' => 'update', 'sub' => $sub ), get_permalink( $billing_page ) ) );
        exit;
    }
}

function wealthiher_action_admin_footer_memberpress() {

    global $hook_suffix;

    if ( \memberpress\courses\models\Course::$cpt == $_GET['post_type'] ?? null && 'edit.php' == $hook_suffix ) {

        $lesson_types_url = add_query_arg( array( 'taxonomy' => 'lesson_type', 'post_type' => \memberpress\courses\models\Lesson::$cpt ), admin_url( 'edit-tags.php' ) );
        $lesson_sponsors_url = add_query_arg( array( 'taxonomy' => 'lesson_sponsor', 'post_type' => \memberpress\courses\models\Lesson::$cpt ), admin_url( 'edit-tags.php' ) );

        $lesson_types_link = sprintf( '<a href="%s" class="page-title-action">%s</a>', $lesson_types_url, __wh( 'Lesson Types' ) );
        $lesson_sponsors_link = sprintf( '<a href="%s" class="page-title-action">%s</a>', $lesson_sponsors_url, __wh( 'Lesson Sponsors' ) );

        ?>
        <script>
            jQuery(document).ready(($) => {
                $('.wrap .wp-header-end').before("<?php echo addslashes( $lesson_types_link . $lesson_sponsors_link ); ?>")
            });
        </script>
        <style>
            .page-title-action {
                margin: 0 4px 0 0 !important;
            }
        </style>
        <?php
    }
}

function wealthiher_action_mepr_checkout_before_submit() {

    echo '<div class="navigation">';

    if ( false == get_the_ID() ) {

        printf( '<button type="submit" id="registration-next" class="button button-primary mepr-submit">%s<span class="fas fa-spinner fa-spin busy mepr-loading-gif" style="display: none;"></span></button>', __wh( 'Finish' ) );

    } else {

        printf( '<a href="%s" type="button" id="registration-prev" class="button button-primary">%s</a>',  add_query_arg( array( 'logged_in_allowed' => 'true', 'section' => 'membership' ), wp_registration_url() ), __wh( 'Back' ) );
        printf( '<button type="submit" id="registration-next" class="button button-primary mepr-submit">%s<span class="fas fa-spinner fa-spin busy mepr-loading-gif" style="display: none;"></span></button>', __wh( 'Next' ) );

    }

    echo '</div>';
}

/*
 * Filters
 */

function wealthiher_filter_wealthiher_layout_slug_memberpress( string $layout_slug, ?WP_Post $wp_post ) {

    $memberpress_options = MeprOptions::fetch();

    if ( ! MeprUtils::is_user_logged_in() ) {

        if ( $memberpress_options->account_page_id == $wp_post->ID ) {
            return 'onboarding';
        }

        $current_post = MeprUtils::get_current_post();
        $uri = $_SERVER['REQUEST_URI'];

        if ( MeprRule::is_locked( $current_post ) || MeprRule::is_uri_locked( $uri ) ) {
            return 'onboarding';
        }

        return $layout_slug;
    }

    $post_id_map = array(
        $memberpress_options->account_page_id => 'gated',
        $memberpress_options->login_page_id => 'onboarding',
        $memberpress_options->thankyou_page_id => 'onboarding',
    );

    if ( array_key_exists( $wp_post->ID, $post_id_map ) ) {
        return $post_id_map[ $wp_post->ID ];
    }

    return $layout_slug;
}

function wealthiher_filter_mepr_is_account_page( bool $is_account_page, mixed $wp_post ) {

    if ( is_int( $wp_post ) ) {
        $wp_post = get_post( $wp_post );
    }

    if ( $wp_post instanceof WP_Post && 'page' == $wp_post->post_type && wealthiher_page_template( WH_PAGE_TEMPLATE_GATED, $wp_post ) ) {
        return true;
    }

    return $is_account_page;
}

function wealthiher_filter_mepr_render_custom_fields( array $custom_fields ) {

    $denylist = array( 'mepr-address-one', 'mepr-address-two', 'mepr-address-state', 'mepr-address-zip' );

    return array_filter( $custom_fields, function ( stdClass $field ) use ( $denylist ) {
        return ! in_array( $field->field_key, $denylist );
    } );
}

function wealthiher_filter_mepr_mailchimptags_add_subscriber_args( array $args ) {


    return $args;
}

function wealthiher_filter_post_type_labels_memberpressgroup( object $labels ) {

    foreach ( $labels as $name => $label ) {

        $search = array( 'group', 'page', 'Group', 'Page' );
        $replace = array( 'plan', 'plan', 'Plan', 'Plan' );

        $labels->$name = __wh( str_replace( $search, $replace, $label ) );

    }

    return $labels;
}

function wealthiher_filter_body_class_memberpress( array $classes ) {

    if ( in_array( get_post_type(), array( \memberpress\courses\models\Lesson::$cpt, \memberpress\courses\models\Quiz::$cpt ) ) ) {
        foreach ( wp_get_post_terms( get_the_ID(), 'lesson_type' ) as $term ) {
            if ( $term instanceof WP_Term ) {
                $classes[] = 'lesson-type-' . $term->slug;
            }
        }
    }

    if ( get_the_ID() == MeprOptions::fetch()->thankyou_page_id || get_post( get_the_ID() )->post_name == 'application-submitted' ) {
        $classes[] = 'sign-up-thank-you';
    }

    return $classes;
}

/*
 * Callbacks
 */

function wealthiher_memberpress_form( AccountControllerActions $action = AccountControllerActions::Home ) {

    $controller = new MeprAccountCtrl();
    $controller->enqueue_scripts( true );

    ob_start();

    match ( $action ) {
        AccountControllerActions::Password => $controller->password(),
        AccountControllerActions::Payments => $controller->payments(),
        AccountControllerActions::Subscriptions => $controller->subscriptions(),
        AccountControllerActions::Update => $controller->update(),
        default => $controller->home(),
    };

    return ob_get_clean();
}

function wealthiher_shortcode_memberpress_form( array $atts, ?string $content = null, string $shortcode_tag = '' ) {

    if ( ! MeprUtils::is_user_logged_in() ) {
        return '';
    }

    $attributes = shortcode_atts( array(
        'action' => AccountControllerActions::Home,
    ), $atts, $shortcode_tag );

    $action = AccountControllerActions::tryFrom( $attributes['action'] ?? 'home' ) ?? AccountControllerActions::Home;

    return wealthiher_memberpress_form( $action );
}

function wealthiher_block_memberpress_form_callback( array $attributes, string $content, WP_Block $block_instance ) {

    if ( ! MeprUtils::is_user_logged_in() ) {
        return '';
    }

    $action = AccountControllerActions::tryFrom( $attributes['controllerAction'] ?? 'home' ) ?? AccountControllerActions::Home;

    return wealthiher_memberpress_form( $action );
}
