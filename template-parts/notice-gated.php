<?php

$heading = $args['heading'] ?? null;
$description = $args['description'] ?? null;
$button_label = $args['button_label'] ?? null;
$button_link = $args['button_link'] ?? null;

?>
<div class="notice">
    <?php if ( ! is_null( $heading ) && ! is_null( $description ) ): ?>
    <div class="text">
        <h3><?php echo $heading; ?></h3>
        <?php echo $description; ?>
    </div>
    <?php endif; ?>
    <?php if ( ! is_null( $button_label ) && ! is_null( $button_link ) ): ?>
    <a href="<?php echo $button_link; ?>" class="button button-primary"><?php echo $button_label; ?></a>
    <?php endif; ?>
</div>