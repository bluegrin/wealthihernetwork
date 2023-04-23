<article class="course">
    <?php echo get_the_post_thumbnail( get_the_ID(), 'full' ) ?>
    <div class="meta">
        <h3 class="title"><?php the_title(); ?></h3>
        <div class="tags">
            <span class="tag"><?php echo get_post_meta( get_the_ID(), 'duration', true ); ?></span>
        </div>
    </div>
    <a href="<?php the_permalink(); ?>" class="cta"><?php _ewh( 'Start Course' ); ?> →</a>
</article>