<footer class="site-footer">
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'gated_footer_menu',
            'walker' => new Wealthiher_Walker_Nav_Menu_Footer,
            'container' => 'nav',
            'container_class' => 'nav-menu',
            'container_id' => 'site-footer-nav-menu',
            'items_wrap' => '<ul>%3$s</ul>',
        )
    );
    ?>
    <div class="colophon">
        <p class="colophon-text"><?= __wh( 'Copyright&nbsp;© WealthiHer&nbsp;2023' ) ?></p>
    </div>
</footer>