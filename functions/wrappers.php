<?php

define( 'WH_TEXT_TYPES', array( 'text', 'password', 'date', 'url' ) );

/**
 * A wrapper for the WordPress __() function. Retrieve the translation of $text, with 'wealthiher' as the domain.
 *
 * @param string $text Text to translate.
 *
 * @return string Translated text.
 *
 * @see __()
 */
function __wh( string $text ): string {
    return __( $text, 'wealthiher' );
}

/**
 * A wrapper for the WordPress _x() function. Retrieve translated string with gettext context.
 *
 * @param string $text Text to translate.
 * @param string $context Context information for the translators.
 *
 * @return string Translated context string without pipe.
 *
 * @see _x()
 */
function _xwh( string $text, string $context ): string {
    return _x( $text, $context, 'wealthiher' );
}

/**
 * A wrapper for the WordPress _e() function. Displays translated text.
 *
 * @param string $text Text to translate.
 *
 * @see _e()
 */
function _ewh( string $text ): void {
    _e( $text, 'wealthiher' );
}

/**
 * A wrapper for the WordPress add_action() function. Adds a callback function to an action hook, with 'wealthiher'
 * automatically prepended to the hook name as the callback name.
 *
 * @param string $hook_name The name of the action to add the callback to.
 * @param ?string $slug @todo Explain
 * @param int $priority Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action. Default 10.
 * @param int $accepted_args Optional. The number of arguments the function accepts. Default 1.
 *
 * @return true Always returns true.
 *
 * @see add_action()
 */
function wh_action( string $hook_name, string $slug = null, int $priority = 10, int $accepted_args = 1 ): bool {

    $function_name = str_replace( '-', '_', $hook_name );

    $callback = ( is_null( $slug ) ) ? sprintf( 'wealthiher_action_%s', $function_name ) : sprintf( 'wealthiher_action_%s_%s', $function_name, $slug );

    if ( ! function_exists( $callback ) ) {
        return true;
    }

    return add_action( $hook_name, $callback, $priority, $accepted_args );
}

/**
 * A wrapper for the WordPress add_filter() function. Adds a callback function to a filter hook, with 'wealthiher'
 * automatically prepended to the hook name as the callback name.
 *
 * @param string $hook_name The name of the filter to add the callback to.
 * @param ?string $slug @todo Explain
 * @param int $priority Optional. Used to specify the order in which the functions
 *                                associated with a particular filter are executed.
 *                                Lower numbers correspond with earlier execution,
 *                                and functions with the same priority are executed
 *                                in the order in which they were added to the filter. Default 10.
 * @param int $accepted_args Optional. The number of arguments the function accepts. Default 1.
 *
 * @return true Always returns true.
 *
 * @global WP_Hook[] $wp_filter A multidimensional array of all hooks and the callbacks hooked to them.
 *
 * @see add_filter()
 */
function wh_filter( string $hook_name, string $slug = null, int $priority = 10, int $accepted_args = 1 ): bool {

    $function_name = str_replace( '-', '_', $hook_name );

    $callback = ( is_null( $slug ) ) ? sprintf( 'wealthiher_filter_%s', $function_name ) : sprintf( 'wealthiher_filter_%s_%s', $function_name, $slug );

    if ( ! function_exists( $callback ) ) {
        return true;
    }

    return add_filter( $hook_name, $callback, $priority, $accepted_args );
}

/**
 * @param string $name
 * @param string $default_text
 *
 * @return string
 * @todo Function explanation
 *
 */
function wh_label( string $name, string $default_text ): string {

    $option_name = sprintf( 'wealthiher_label_%s', $name );

    if ( false !== get_option( $option_name ) ) {
        return (string) get_option( $option_name );
    }

    return __wh( $default_text );

}

/**
 * @param string $name
 *
 * @return string
 * @todo Function explanation
 */
function wh_img_url( string $name ) {
    return get_stylesheet_directory_uri() . '/img/' . $name;
}

/**
 * @param string $name
 *
 * @return string
 */
function wh_svg_markup( string $name ) {
    return file_get_contents( get_stylesheet_directory() . '/img/' . $name ) ?: '';
}

function wh_smart_arrow( string $direction, $classes = array() ) {
    if ( in_array( $direction, array( 'left', 'right' ) ) ) {
        printf( '<span class="smart-arrow %s %s">%s</span>', $direction, implode( ' ', $classes ), wh_svg_markup( 'arrow-' . $direction . '.svg' ) );
    }
}

/**
 * @param array $assets
 *
 * @return void
 *
 * @todo Function explanation
 */
function wh_enqueue( array $assets ) {

    foreach ( $assets as $args ) {

        $type = $args['type'] ?? null;
        $handle = $args['handle'] ?? null;
        $src = $args['src'] ?? null;

        if ( is_null( $type ) || is_null( $handle ) || is_null( $src ) ) {
            continue;
        }

        $deps = array();
        $ver = WH_THEME_VERSION;

        if ( array_key_exists( 'deps', $args ) ) {
            $deps = $args['deps'];
        }

        if ( array_key_exists( 'ver', $args ) ) {
            $ver = $args['ver'];
        }

        if ( 'style' == $type ) {
            wp_enqueue_style( $handle, $src, $deps, $ver );
        }

        if ( 'script' == $type ) {
            wp_enqueue_script( $handle, $src, $deps, $ver, true );

            if ( isset( $args['localize'] ) && true == $args['localize'] ) {
                wp_localize_script( $handle, $handle . '_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
            }
        }

    }

}

/**
 * @param string $singular
 * @param string $plural
 * @param string $image
 *
 * @return string[]
 */
function wh_post_type_labels( string $singular, string $plural, string $image = 'Featured Image' ) {

    $singularLower = mb_convert_case( $singular, MB_CASE_LOWER );
    $pluralLower = mb_convert_case( $plural, MB_CASE_LOWER );
    $imageLower = mb_convert_case( $image, MB_CASE_LOWER );

    return array(
        'name' => _xwh( $plural, 'Post type general name' ),
        'singular_name' => _xwh( $singular, 'Post type singular name' ),
        'menu_name' => _xwh( $plural, 'Admin Menu text' ),
        'name_admin_bar' => _xwh( $singular, 'Add New on Toolbar' ),
        'add_new' => __wh( 'Add New' ),
        'add_new_item' => __wh( sprintf( 'Add New %s', $singular ) ),
        'new_item' => __wh( sprintf( 'New %s', $singular ) ),
        'edit_item' => __wh( sprintf( 'Edit %s', $singular ) ),
        'view_item' => __wh( sprintf( 'View %s', $singular ) ),
        'all_items' => __wh( sprintf( 'All %s', $plural ) ),
        'search_items' => __wh( sprintf( 'Search %s', $plural ) ),
        'parent_item_colon' => __wh( sprintf( 'Parent %s:', $plural ) ),
        'not_found' => __wh( sprintf( 'No %s found.', $pluralLower ) ),
        'not_found_in_trash' => __wh( sprintf( 'No %s found in Trash.', $pluralLower ) ),
        'featured_image' => _xwh( sprintf( '%s %s', $singular, $image ), 'Overrides the “Featured Image” phrase for this post type. Added in 4.3' ),
        'set_featured_image' => _xwh( sprintf( 'Set %s', $imageLower ), 'Overrides the “Set featured image” phrase for this post type. Added in 4.3' ),
        'remove_featured_image' => _xwh( sprintf( 'Remove %s', $imageLower ), 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3' ),
        'use_featured_image' => _xwh( sprintf( 'Use as %s', $imageLower ), 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3' ),
        'archives' => _xwh( sprintf( '%s archives', $singular ), 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4' ),
        'insert_into_item' => _xwh( sprintf( 'Insert into %s', $singularLower ), 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4' ),
        'uploaded_to_this_item' => _xwh( sprintf( 'Uploaded to this %s', $singularLower ), 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4' ),
        'filter_items_list' => _xwh( sprintf( 'Filter %s list', $pluralLower ), 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4' ),
        'items_list_navigation' => _xwh( sprintf( '%s list navigation', $plural ), 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4' ),
        'items_list' => _xwh( sprintf( '%s list', $plural ), 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4' ),
    );
}

/**
 * @param string $singular
 * @param string $plural
 *
 * @return array
 */
function wh_taxonomy_labels( string $singular, string $plural ) {

    return array(
        'name' => _xwh( $plural, 'taxonomy general name' ),
        'singular_name' => _xwh( $singular, 'taxonomy singular name' ),
        'search_items' => __wh( sprintf( 'Search %s', $plural ) ),
        'all_items' => __wh( sprintf( 'All %s', $plural ) ),
        'parent_item' => __wh( sprintf( 'Parent %s', $singular ) ),
        'parent_item_colon' => __wh( sprintf( 'Parent %s:', $singular ) ),
        'edit_item' => __wh( sprintf( 'Edit %s', $singular ) ),
        'update_item' => __wh( sprintf( 'Update %s', $singular ) ),
        'add_new_item' => __wh( sprintf( 'Add New %s', $singular ) ),
        'new_item_name' => __wh( sprintf( 'New %s Name', $singular ) ),
        'menu_name' => __wh( sprintf( '%s', $plural ) ),
    );
}

/**
 * @param array $args
 * @param array $fields
 *
 * @return void
 */
function wh_add_meta_box( array $args, array $fields ) {

    $meta_box_id = $args['id'] ?? null;
    $post_types = $args['post_types'] ?? array();
    $title = $args['title'] ?? null;
    $screen = $args['screen'] ?? $post_types;
    $context = $args['context'] ?? 'advanced';
    $priority = $args['priority'] ?? 'default';

    if ( is_null( $meta_box_id ) || is_null( $title ) || is_null( $screen ) || is_null( $context ) ) {
        return;
    }

    add_action( 'add_meta_boxes', function () use ( $meta_box_id, $title, $screen, $context, $priority, $fields ) {
        add_meta_box(
            $meta_box_id,
            $title,
            function ( $wp_post ) use ( $meta_box_id, $fields ) {

                foreach ( $fields as $field ) {

                    $id = $field['id'] ?? null;
                    $label = $field['label'] ?? null;
                    $type = $field['type'] ?? 'text';

                    if ( is_null( $id ) || is_null( $label ) ) {
                        continue;
                    }

                    wp_nonce_field( $meta_box_id . '_meta_box', $id . '_nonce' );

                    $value = get_post_meta( $wp_post->ID, $id, true );

                    if ( in_array( $type, WH_TEXT_TYPES ) ) {
                        get_template_part( 'template-parts/admin/field', 'text', array(
                            'id' => $id,
                            'label' => $label,
                            'type' => $type,
                            'value' => $value
                        ) );
                    }
                }

            },
            $screen,
            $context,
            $priority,
        );
    } );

    add_action( 'save_post', function ( $post_ID ) use ( $meta_box_id, $post_types, $fields ) {

        if ( ! in_array( get_post_type( $post_ID ), $post_types ) || wp_is_post_revision( $post_ID ) || wp_is_post_autosave( $post_ID ) ) {
            return;
        }

        foreach ( $fields as $field ) {

            $id = $field['id'] ?? null;

            if ( is_null( $id ) ) {
                continue;
            }

            if ( isset( $_POST[$id . '_nonce'] ) && wp_verify_nonce( $_POST[$id . '_nonce'], $meta_box_id . '_meta_box' ) ) {

                if ( isset( $_POST[$id] ) && ! empty( $_POST[$id] ) ) {
                    update_post_meta( $post_ID, $id, $_POST[$id] );
                } else {
                    delete_post_meta( $post_ID, $id );
                }

            }

        }

    } );
}

/**
 * @param string $post_type
 * @param array $meta_boxes
 *
 * @return void
 */
function wh_add_post_type_meta( string $post_type, array $meta_boxes ) {

    foreach ( $meta_boxes as $id => $config ) {

        $args = array(
            'id' => $post_type . '_' . $id,
            'title' => $config['title'],
            'post_types' => array( $post_type ),
            'context' => $config['context'] ?? 'advanced',
            'priority' => $config['priority'] ?? 'default',
        );

        $fields = array();

        foreach ( $config['fields'] ?? array() as $field ) {

            if ( is_null( $field['id'] ?? null ) ) {
                continue;
            }

            $fields[] = array(
                'id' => $post_type . '_' . $field['id'],
                'label' => __wh( $field['label'] ?? mb_convert_case( str_replace( '_', ' ', $field['id'] ), MB_CASE_TITLE ) ),
                'type' => $field['type'] ?? 'text',
            );

        }

        wh_add_meta_box( $args, $fields );

    }
}

/**
 * @param int $post_id
 * @param string $meta_key
 *
 * @return mixed
 */
function wh_get_post_meta( $post_id, $meta_key ) {
    return get_post_meta( $post_id, get_post_type( $post_id ) . '_' . $meta_key, true );
}

/**
 * @param int $post_id
 * @param string $meta_key
 *
 * @return void
 */
function wh_the_post_meta( $post_id, $meta_key ) {
    echo wh_get_post_meta( $post_id, $meta_key );
}

/**
 * @param string $hook_name
 * @param string|object $callback_class
 * @param string $callback_method
 * @param int $filter_priority
 *
 * @return void
 */
function remove_filter_object( string $hook_name, string|object $callback_class, string $callback_method, int $filter_priority ): void {

    if ( is_object( $callback_class ) ) {

        remove_filter( $hook_name, _wp_filter_build_unique_id( $hook_name, array( $callback_class, $callback_method ), $filter_priority ) . $callback_method, $filter_priority );

    } else {

        add_filter( $hook_name, function ( mixed $filtered ) use ( $hook_name, $callback_class, $callback_method, $filter_priority ) {

            global $wp_filter;

            $hook = $wp_filter[ $hook_name ] ?? null;

            if ( $hook instanceof WP_Hook ) {

                foreach ( $hook->callbacks as $priority => $callbacks ) {

                    if ( $filter_priority == $priority ) {

                        foreach ( $callbacks as $idx => $callback ) {

                            $function = $callback['function'] ?? null;

                            if ( is_array( $function ) ) {

                                $object = $function[0] ?? null;
                                $method = $function[1] ?? null;

                                if ( $object instanceof $callback_class && $callback_method == $method ) {
                                    unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $idx ] );
                                }

                            }

                        }

                    }

                }

            }

            return $filtered;

        }, PHP_INT_MIN );

    }

}
