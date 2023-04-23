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

    foreach ( $fields as $name => $config ) {

        $type = $config['type'] ?? 'text';
        $label = $config['question'] ?? null;
        $show_labels = $config['show_labels'] ?? true;
        $placeholder = $config['placeholder'] ?? null;
        $options = $config['options'] ?? array();

        get_template_part( 'template-parts/registration-field', null, array(
            'type' => $type,
            'name' => $name,
            'id' => $name,
            'label' => $label,
            'show_labels' => $show_labels,
            'placeholder' => $placeholder,
            'options' => $options,
        ) );

    }

    ?>
    <input type="hidden" name="section" id="section_<?php echo $section; ?>" value="<?php echo $section; ?>">
    <div class="messages">&nbsp;</div>
</div>
