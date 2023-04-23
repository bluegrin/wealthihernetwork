<?php 

$args = array();

if ( 'post' == get_post_type() ) {
    $args = array( 'post_id' => get_option( 'page_for_posts', true ) );
}

if ( is_archive() && get_queried_object() instanceof WP_Term ) {
    $args = array(
        'title' => get_queried_object()->name,
        'subtitle' => get_taxonomy( get_queried_object()->taxonomy )->name,
    );
}

if ( is_archive() && get_queried_object() instanceof WP_Post_Type ) {
    $args = array(
        'title' => get_queried_object()->label,
    );
}

get_template_part( 'template-parts/title', wealthiher_layout_slug(), $args );

?>
<?php if ( have_posts() ): ?>
<div class="posts">
<?php while ( have_posts() ): the_post(); ?>
<?php get_template_part( 'template-parts/post', get_post_type() ); ?>
<?php endwhile; ?>
</div>
<nav class="pagination">
<?php echo paginate_links( array( 'prev_text' => '&nbsp;', 'next_text' => '&nbsp;' ) ); ?>
</nav>
<?php endif; ?>
