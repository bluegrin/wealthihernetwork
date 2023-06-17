<?php

$section = $args['section'] ?? null;
$heading = $args['heading'] ?? null;
$description = $args['description'] ?? null;
$fields = $args['fields'] ?? array();

?>
<div class="heading"><?php echo $heading; ?></div>
<div class="section">
    <?php if ( ! is_null( $description ) ): ?><div class="description"><?php echo $description; ?></div><?php endif; ?>
    <?php

    if ( 'password' === $section && is_user_logged_in() ): ?>
    <p><?php _e( sprintf( 'You have already set a password. To change your password, <a href="%s" target="_blank">click here</a>.', esc_url( wp_lostpassword_url() ) ) ); ?></p>
    <?php else:

    foreach ( $fields as $name => $config ) {

        $type = $config['type'] ?? 'text';
        $label = $config['question'] ?? null;
        $show_labels = $config['show_labels'] ?? true;
        $placeholder = $config['placeholder'] ?? null;
        $options = $config['options'] ?? array();
        $value = null;

        if ( is_user_logged_in() ) {

            $user = wp_get_current_user();

            $value = match ( $name ) {
                'user_first_name' => $user->first_name,
                'user_last_name' => $user->last_name,
                'user_email' => $user->user_email,
                'mepr_user_password', 'mepr_user_password_confirm', 'journey', 'mepr_product_id' => null,
                default => get_user_meta( $user->ID, $name, true ),
            };

        }

        get_template_part( 'template-parts/registration-field', null, array(
            'type' => $type,
            'name' => $name,
            'id' => $name,
            'label' => $label,
            'show_labels' => $show_labels,
            'placeholder' => $placeholder,
            'options' => $options,
            'value' => $value,
        ) );

    }

    endif;

    ?>
    <input type="hidden" name="section" id="section_<?php echo $section; ?>" value="<?php echo $section; ?>">
    <div class="messages">&nbsp;</div>
</div>
