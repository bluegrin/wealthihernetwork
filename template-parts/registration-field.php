<?php

$type = $args['type'] ?? 'text';
$name = $args['name'] ?? null;
$id = $args['id'] ?? null;
$label = $args['label'] ?? null;
$show_labels = $args['show_labels'] ?? true;
$placeholder = $args['placeholder'] ?? null;
$options = $args['options'] ?? array();

if ( is_null( $type ) || is_null( $name ) ) {
    return;
}

switch ( $type ) {

    case 'select':

        $items = array( sprintf( '<option disabled selected>%s</option>', $placeholder ) );

        foreach ( $options as $value => $text ) {
            $items[] = sprintf( '<option value="%s">%s</option>', $value ?? '', __wh( $text ?? '' ) );
        }

        printf( '<label for="%3$s">%1$s</label><select name="%2$s" id="%3$s">%4$s</select>', $label, $name, $id, implode( '', $items ) );

        break;

    case 'checkboxes':
        foreach ( $options as $value => $text ) {
            printf( '<label for="%3$s_%4$s"><input type="checkbox" name="%2$s[%4$s]" id="%3$s_%4$s">%1$s</label>', __wh( $text ), $name, $id, $value );
        }
        break;

    case 'radio':
        foreach ( $options as $value => $text ) {
            printf( '<label for="%3$s_%4$s"><input type="radio" name="%2$s" id="%3$s_%4$s" value="%4$s">%1$s</label>', __wh( $text ), $name, $id, $value );
        }
        break;

    case 'textarea':
        printf( '<label for="%3$s"%5$s>%1$s</label><div class="textarea-container"><div class="textarea-resizer"><textarea name="%2$s" id="%3$s" placeholder="%4$s" oninput="this.parentNode.dataset.replicatedValue = this.value" rows="1"></textarea></div></div>', $label, $name, $id, $placeholder, $show_labels ? '' : ' class="sr-only"' );
        break;

    default:
        printf( '<label for="%4$s"%6$s>%1$s</label><input type="%2$s" name="%3$s" id="%4$s" placeholder="%5$s">', $label, $type, $name, $id, $placeholder, $show_labels ? '' : ' class="sr-only"' );
        break;

}
