<header class="site-header">
    <section class="header">
        <a href="<?= home_url() ?>" class="logo"><img src="<?= wh_img_url( 'wealthiher-network-icon.png' ) ?>" alt="WealthiHerNetwork" width="70" height="71"></a>
        <div class="buttons">
            <button class="menu-toggle" aria-controls="site-header-nav-menu">
                <img src="<?= wh_img_url( 'menu-open.svg' ) ?>" alt="" width="30" height="24">
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
    </section>
    <section class="user">
        <?php echo get_avatar( get_current_user_id(), 82 ); ?>
        <span class="welcome"><?php _ewh( 'Welcome Back' ); ?>,<br><?php echo get_user_meta( get_current_user_id(), 'first_name', true ); ?></span>
    </section>
    <section class="menu">
        <?php
        
        get_template_part( 'template-parts/course-progress' );
        
        wp_nav_menu(
            array(
                'theme_location' => 'gated_header_menu',
                'walker' => new Wealthiher_Walker_Nav_Menu_Header,
                'container' => 'nav',
                'container_class' => 'nav-menu',
                'container_id' => 'site-header-nav-menu',
                'items_wrap' => '<ul>%3$s</ul>',
            )
        );

        get_template_part( 'template-parts/gated-events-upcoming' );

        ?>
    </section>
</header>
