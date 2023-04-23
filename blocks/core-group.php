<?php

wh_filter( 'pre_render_block', 'core_groups', PHP_INT_MAX, 3 );

function wealthiher_filter_pre_render_block_core_groups( string $pre_render = null, array $parsed_block = array(), $parent_block = null ) {

    global $wh_skip_callouts;

    $block_name = $parsed_block['blockName'] ?? null;
    $class_name = $parsed_block['attrs']['className'] ?? null;

    $is_callout = 'core/group' == $block_name && 'is-style-callout' == $class_name;

    if ( ! $is_callout && $parent_block instanceof WP_Block ) {

        $parent_block_name = $parent_block->parsed_block['blockName'] ?? null;
        $parent_class_name = $parent_block->parsed_block['attrs']['className'] ?? null;

        $is_callout = 'core/group' == $parent_block_name && 'is-style-callout' == $parent_class_name;

    }

    if ( is_null( $wh_skip_callouts ) ) {
        return $pre_render;
    }

    if ( true === $wh_skip_callouts ) {
        $pre_render = $is_callout ? '' : null;
    }

    if ( false === $wh_skip_callouts ) {
        $pre_render = $is_callout ? null : '';
    }

    return $pre_render;
}
