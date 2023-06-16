<main class="site-main">
    <?php get_template_part( 'template-parts/title', wealthiher_layout_slug(), array( 'title' => __wh( 'Last Step!' ) ) ); ?>
    <main id="entry-content">
        <?php if ( isset( $_GET['onboarding'] ) && in_array( $_GET['onboarding'], array( 'digital-pass', 'haute-membership' )) && is_user_logged_in() ): $user = wp_get_current_user(); ?>
        <h2 class="onboarding-summary"><?php _e( 'Confirm your details:' ); ?></h2>
        <dl class="onboarding-summary">
        <?php

        foreach ( WEALTHIHER_REGISTRATION_FIELDS as $name => $config ):

            if ( in_array( $name, array( 'mepr_user_password', 'mepr_user_password_confirm', 'journey', 'mepr_product_id', 'mepr_product_id_haute' ) ) ) {
                continue;
            }

            if ( isset( $config['journey'] ) && $_GET['onboarding'] != $config['journey'] ) {
                continue;
            }

            $term = match ( $name ) {
                'haute_question_1', 'haute_question_2' => sprintf( '%s<br><small>%s</small>', __wh( 'Application Answer' ), $config['question'] ),
                default => $config['label'] ?? $name,
            };

            $value = match ( $name ) {
                'user_first_name' => $user->first_name,
                'user_last_name' => $user->last_name,
                'user_email' => $user->user_email,
                default => get_user_meta( $user->ID, $name, true ),
            };

            switch ( $config['type'] ) {

                case 'checkboxes':

                    $definitions = array();

                    foreach ( array_keys( $value ) as $key ) {
                        $definitions[] = $config['options'][$key] ?? '';
                    }

                    $definition = implode( ', ', $definitions );

                    break;

                case 'select':
                case 'radio':
                    $definition = $config['options'][$value] ?? '';
                    break;

                default:
                    $definition = empty( $value ) ? '<i style="color: #ccc;">N/A</i>' : $value;

            }

            ?>
            <dt><?php echo $term; ?></dt>
            <dd><?php echo $definition; ?></dd>
        <?php endforeach; ?>
        </dl>
        <?php endif; ?>
        <?php

        /**
        $complete_allowed = get_transient( 'wealthiher_application_complete_allowed' );

        delete_transient( 'wealthiher_application_complete_allowed' );

        if ( WEALTHIHER_HAUTE_MEMBERSHIP_PRODUCT_ID == get_the_ID() && 'true' !== $complete_allowed ) {

            printf( '<div class="sign-up-thank-you"><p>%s %s</p><p><a href="%s">%s</a></p></div>', get_the_title(), __wh( 'is only available to select members.' ), wp_registration_url(), __wh( 'Apply Here' ) );

        } else {

            the_content();

        }
         */
        the_content();
        ?>
    </main>
</main>
