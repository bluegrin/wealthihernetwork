<?php

$upcoming = tribe_get_events();

if ( ! empty( $upcoming ) ):

?>
<section id="upcoming">
    <h2><?php _ewh( 'Upcoming events' ); ?></h2>
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ( $upcoming as $event ): ?>
                <li class="splide__slide">
                    <?php get_template_part( 'template-parts/post', 'tribe_events', array( 'event' => $event ) ); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="splide__arrows">
            <button class="splide__arrow splide__arrow--prev">←</button>
            <button class="splide__arrow splide__arrow--next">→</button>
        </div>
    </div>
</section>
<?php

endif;

$nearest = tribe_get_events( array( 'orderby' => 'rand' ) );

if ( ! empty( $nearest ) ):

?>
<section id="nearest">
    <h2><?php _ewh( 'Events near you' ); ?></h2>
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ( $nearest as $event ): ?>
                <li class="splide__slide">
                    <?php get_template_part( 'template-parts/post', 'tribe_events', array( 'event' => $event ) ); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="splide__arrows">
            <button class="splide__arrow splide__arrow--prev">←</button>
            <button class="splide__arrow splide__arrow--next">→</button>
        </div>
    </div>
</section>
<?php

endif;

