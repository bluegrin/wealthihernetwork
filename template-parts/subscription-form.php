<?php

if ( ! WH_PLUGIN_ACTIVE_MEMBERPRESS || ! MeprUtils::is_user_logged_in() ) {
    return;
}

/** @var MeprUser $memberpress_user */
$memberpress_user = MeprUtils::get_currentuserinfo();

$memberpress_memberships = get_posts( array(
    'post_type' => MeprProduct::$cpt,
    'post_status' => 'publish',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'posts_per_page' => -1,
) );

/** @var MeprGroup[] $memberpress_groups */
$memberpress_groups = array();

/** @var MeprProduct[][] $memberpress_products */
$memberpress_products = array();

foreach ( $memberpress_memberships as $post ) {
    
    $product = MeprProduct::get_one( $post->ID );
    $group = $product->group();
    
    $index = $group ? $group->ID : 'standalone';

    $memberpress_groups[$index] = $group;
    $memberpress_products[$index][$product->ID] = $product;
    
}

foreach ( $memberpress_groups as $index => $group ): if ( 'standalone' != $index && $group instanceof MeprGroup ):
    
    
    
?>
<section id="form_<?php echo $group->ID; ?>">
    <div class="form-group">
        <label for="group_<?php echo $group->ID; ?>"><?php echo 1 === count( $memberpress_groups ) ? __wh( 'Membership Type') : $group->post_title; ?></label>
        <select id="group_<?php echo $group->ID; ?>">
            <?php foreach ( $memberpress_products[ $group->ID ] as $product ): if ( $product->can_you_buy_me() ): ?>
            <option value="<?php echo get_the_permalink( $product->IO ); ?>"<?php if ( $memberpress_user->is_already_subscribed_to( $product->ID ) ): echo ' selected'; endif; ?>><?php echo $product->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
</section>
<?php

endif; endforeach;