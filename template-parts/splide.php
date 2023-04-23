<div class="splide">
    <div class="splide__track">
        <ul class="splide__list">
            <?php if ( $args['query'] ?? null instanceof WP_Query ): while ( $args['query']->have_posts() ): $args['query']->the_post(); ?>
            <li class="splide__slide">
                <?php get_template_part( $args['template_part_slug'], $args['template_part_name'] ); ?>
            </li>
            <?php endwhile; endif; ?>
        </ul>
    </div>
    <div class="splide__arrows">
        <button class="splide__arrow splide__arrow--prev">←</button>
        <button class="splide__arrow splide__arrow--next">→</button>
    </div>
</div>
