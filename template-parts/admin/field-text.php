<?php

$id = $args['id'] ?? null;
$label = $args['label'] ?? null;
$type = $args['type'] ?? 'text';
$value = $args['value'] ?? null;

if ( is_null( $id ) || is_null( $label ) ) {
	return;
}

?>
<div class="form-field">
	<label for="<?= $id ?>"><?= __wh( $label ) ?></label>
	<input name="<?= $id ?>" id="<?= $id ?>" type="<?= $type ?>" value="<?= $value ?>">
</div>
