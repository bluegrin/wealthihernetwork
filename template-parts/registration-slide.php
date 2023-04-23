<?php

$section_name = $args['name'] ?? null;
$section_config = $args['config'] ?? null;
$journey = $args['journey'] ?? 'start';

?>
<li class="splide__slide registration-<?php echo $section_name; ?>" data-journey="<?php echo $journey; ?>">
    <?php

    $heading = $section_config['heading'] ?? null;
    $description = $section_config['description'] ?? null;
    $fields = array();

    foreach ( WEALTHIHER_REGISTRATION_FIELDS as $field_name => $field_config ) {
        if ( $section_name == $field_config['section'] ) {

            if ( false == $section_config['field_labels'] ?? true ) {
                $field_config['show_labels'] = false;
            }

            $fields[ $field_name ] = $field_config;

        }
    }

    get_template_part( 'template-parts/registration-section', null, array( 'section' => $section_name, 'heading' => $heading, 'description' => $description, 'fields' => $fields ) );

    if ( true == $section_config['submit_slide'] ?? false ) {
        printf( '<input type="hidden" name="submit" value="%s">', $journey );
    }

    ?>
</li>
