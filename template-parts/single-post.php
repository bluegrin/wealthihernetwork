<article class="post">
	<div class="image">
		<?= get_the_post_thumbnail( get_the_ID(), 'full' ) ?>
	</div>
	<div class="meta">
		<p class="author"><?= __wh( 'By' ) ?> <?= get_the_author_meta( 'display_name' ) ?></p>
		<h2 class="title"><?= get_the_title() ?></h2>
		<div class="categories">
			<?php foreach ( wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) ) as $category ): ?>
				<a href="<?= get_category_link( $category ) ?>" class="category"><?= $category->name ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="content">
		<?php the_content(); ?>
	</div>
</article>
<aside class="related paged">
<h1>Stories you might like</h1>
<?php

$related = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4 ) );

if ( $related->have_posts() ) {
    echo '<div class="posts">';
    while ( $related->have_posts() ) {
        $related->the_post();
        get_template_part( 'template-parts/post', 'post' );
    }
    echo '</div>';
}

wp_reset_postdata();

?>
</aside>
<?php get_template_part( 'template-parts/interest' ); ?>