<header class="site-header<?php if ( ! is_front_page() ): echo ' solid'; endif; ?>">
    <div class="buttons">
        <button class="menu-toggle" aria-controls="site-header-nav-menu">
            <img src="<?= wh_img_url( 'menu-open.svg' ) ?>" alt="" width="30" height="24">
            <span class="sr-only">Toggle Menu</span>
        </button>
        <?php if ( WH_PLUGIN_ACTIVE_MEMBERPRESS && MeprUtils::is_user_logged_in() ): ?>
        <a href="/account/personal-details" class="button-registration button button-primary">Your Account</a>
        <?php elseif ( WH_PLUGIN_ACTIVE_MEMBERPRESS && ! MeprUtils::is_user_logged_in() ): ?>
            <a href="<?php echo esc_url( wp_login_url() ); ?>" class="button-registration button button-primary">Sign Up / Login</a>
        <?php else: ?>
        <a href="/membership" class="button-registration button button-primary">Learn More</a>
        <?php endif; ?>
    </div>
    <a href="<?= home_url() ?>" id="site-logo"><img src="<?= wh_img_url( 'wealthiher-network-logo.png' ) ?>" alt="WealthiHerNetwork" width="250" height="83"></a>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'ungated_header_primary_menu',
			'walker' => new Wealthiher_Walker_Nav_Menu_Header,
			'container' => 'nav',
			'container_class' => 'nav-menu',
			'container_id' => 'site-header-nav-menu',
			'items_wrap' => '<ul>%3$s</ul>',
		)
	);
	?>
</header>