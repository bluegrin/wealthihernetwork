<main class="site-main">
    <?php get_template_part( 'template-parts/title', wealthiher_layout_slug(), array( 'title' => __wh( 'Last Step!' ) ) ); ?>
    <main id="entry-content">
        <?php

        $complete_allowed = get_transient( 'wealthiher_application_complete_allowed' );

        delete_transient( 'wealthiher_application_complete_allowed' );

        if ( WEALTHIHER_HAUTE_MEMBERSHIP_PRODUCT_ID == get_the_ID() && 'true' !== $complete_allowed ) {

            printf( '<div class="sign-up-thank-you"><p>%s %s</p><p><a href="%s">%s</a></p></div>', get_the_title(), __wh( 'is only available to select members.' ), wp_registration_url(), __wh( 'Apply Here' ) );

        } else {

            the_content();

        }

        ?>
    </main>
</main>
