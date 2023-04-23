<article class="post">
    <a href="<?= get_the_permalink() ?>" class="image">
        <?= get_the_post_thumbnail( get_the_ID(), 'full' ) ?>
    </a>
    <div class="meta">
        <p class="author"><?= __wh( 'By' ) ?> <?= get_the_author_meta( 'display_name' ) ?></p>
        <h2 class="title"><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></h2>
        <div class="categories">
	        <?php foreach ( wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) ) as $category ): ?>
            <a href="<?= get_category_link( $category ) ?>" class="category"><?= $category->name ?></a>
	        <?php endforeach; ?>
        </div>
    </div>
</article>