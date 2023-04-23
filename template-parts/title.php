<?php

$post_id = $args['post_id'] ?? get_the_ID();

$subtitle = $args['subtitle'] ?? get_post_meta( $post_id, 'wh_subtitle', true );
$title = $args['title'] ?? get_post_meta( $post_id, 'wh_title', true );

$background_color = $args['color'] ?? get_post_meta( $post_id, 'wh_header_color', true );

$waves_top = $args['waves_top'] ?? (bool) get_post_meta( $post_id, 'wh_header_waves_top', true );
$waves_bottom = $args['waves_bottom'] ?? (bool) get_post_meta( $post_id, 'wh_header_waves_bottom', true );

$classes = array( 'title' );

if ( $background_color ) {
    $classes[] = sprintf( 'has-bg bg-%s', $background_color );
}

$bg_classes = array( 'bg' );

if ( $waves_top ) {
    $bg_classes[] = 'waves-top';
}

if ( $waves_bottom ) {
    $bg_classes[] = 'waves-bottom';
}

?>
<header class="<?= implode( ' ', $classes ) ?>">
    <div class="<?= implode( ' ', $bg_classes ) ?>">
        <?php if ( $waves_top ): ?>
        <svg width="1728" height="119.06596" viewBox="0 0 1728 119.06596" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="waves top">
            <path class="waves-path" d="M 0,0 V 84.005859 C 103.92682,117.90684 251.17475,140.64064 420.13281,87.269531 559.04667,43.388475 708.89687,48.614072 827.46875,67.001953 946.04063,85.389835 1091.641,87.270054 1238.3809,37.970703 1395.6899,-14.878304 1599.033,-1.8321511 1728,13.609375 V 0 Z" />
        </svg>
        <?php endif; ?>
        <h1><?php if ( $subtitle ): ?><small><?= $subtitle ?></small><?php endif; if ( $title ): echo $title; else: echo get_the_title( $post_id ); endif; ?></h1>
    </div>
	<?php if ( $waves_bottom ): ?>
    <svg width="1728" height="119.06596" viewBox="0 0 1728 119.06596" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="waves bottom">
        <path class="waves-path" d="M 0,0 V 84.005859 C 103.92682,117.90684 251.17475,140.64064 420.13281,87.269531 559.04667,43.388475 708.89687,48.614072 827.46875,67.001953 946.04063,85.389835 1091.641,87.270054 1238.3809,37.970703 1395.6899,-14.878304 1599.033,-1.8321511 1728,13.609375 V 0 Z" />
    </svg>
	<?php endif; ?>
</header>
