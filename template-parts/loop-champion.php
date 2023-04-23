<?php

$level_terms = get_terms( 'wh_level', array(
	'orderby' => 'meta_value_num',
	'order' => 'ASC',
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => 'wh_partner_order',
			'compare' => 'NOT EXISTS'
		),
		array(
			'key' => 'wh_partner_order',
			'value' => 0,
			'compare' => '>='
		)
	),
	'hide_empty' => true,
	'parent' => 0
) );

?>

<?php foreach ( $level_terms as $level_term ): ?>
<section class="partner-level" id="<?= $level_term->slug ?>">
    <h2 class="partner-level-heading"><?= esc_html( $level_term->name ) ?></h2>
    <?php
    
    $partner_posts = get_posts( array(
        'post_type' => 'wh_partner',
        'post_status' => 'publish',
        'meta_key' => sprintf( '_reorder_term_%s_%s', 'wh_level', $level_term->slug ),
        'orderby' => 'meta_value_num title',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'wh_level',
                'terms' => $level_term->slug,
                'field' => 'slug',
            ),
        ),
    ) );
    
    ?>
    <?php foreach ( $partner_posts as $partner_post ): ?>
    <section class="partner" id="<?= $partner_post->post_name ?>">
        <h3 class="partner-heading"><?= get_the_post_thumbnail( $partner_post, 'full' ) ?></h3>
        <?php

        $partner_term_id = get_post_meta( $partner_post->ID, 'wh_partner_term_id', true );
        
        $partner_term = get_term( $partner_term_id, 'wh_partner' );
        
        $champion_posts = get_posts( array(
            'post_type' => 'wh_champion',
            'post_status' => 'publish',
            'meta_key' => sprintf( '_reorder_term_%s_%s', 'wh_partner', $partner_term->slug ),
            'orderby' => 'meta_value_num title',
            'order' => 'ASC',
            'posts_per_page' => -1,
        ) );
        
        ?>
        <?php if ( ! empty( $champion_posts ) ): ?>
        <ul class="champions">
            <?php foreach ( $champion_posts as $champion_post ): ?>
            <li class="champion" id="<?= $champion_post->post_name ?>">
                <figure>
                    <?= get_the_post_thumbnail( $champion_post, 'wp-champion' ); ?>
                    <figcaption><?= $champion_post->post_title ?></figcaption>
                </figure>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </section>
    <?php endforeach; ?>
</section>
<?php endforeach; ?>
