<?php

$post_id = $args['post_id'] ?? get_the_ID();

$subtitle = $args['subtitle'] ?? get_post_meta( $post_id, 'wh_subtitle', true );
$title = $args['title'] ?? get_post_meta( $post_id, 'wh_title', true );

?>
<h1><?php if ( $subtitle ): ?><small><?= $subtitle ?></small><?php endif; if ( $title ): echo $title; else: echo get_the_title( $post_id ); endif; ?></h1>
