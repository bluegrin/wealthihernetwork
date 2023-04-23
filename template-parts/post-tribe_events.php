<?php

$event = $args['event'] ?? null;

$tribe_event_url = esc_url( get_post_meta( $event->ID, '_EventURL', true ) );
$link_target = ' target="_blank"';

if ( empty( $tribe_event_url ) ) {
    $tribe_event_url = get_the_permalink( $event->ID );
    $link_target = '';
}

?>
<article class="event">
    <?php echo get_the_post_thumbnail( $event->ID, 'wh-gated-header-event' ); ?>
    <header class="meta">
        <h5 class="title"><?php echo get_the_title( $event->ID ); ?></h5>
        <div class="tags">
            <?php foreach ( wp_get_post_terms( $event->ID, 'tribe_events_cat' ) as $event_cat ): ?>
            <span class="tag"><?php echo $event_cat->name; ?></span>
            <?php endforeach; ?>
            <span class="tag"><?php echo date( 'F Y', strtotime( $event->event_date_utc ) ); ?></span>
        </div>
    </header>
    <a href="<?php echo $tribe_event_url; ?>" class="cta"<?php echo $link_target; ?>><?php _ewh( 'RSVP Now' ); ?> →</a>
</article>
