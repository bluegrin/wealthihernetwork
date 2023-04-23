<?php

if ( ! WH_PLUGIN_ACTIVE_GRAVITY_FORMS ) {
    return;
}

//wh_filter( 'gform_field_choices', null, 10, 2 );
//wh_filter( 'gform_field_container', null, 10, 6 );
//wh_filter( 'gform_field_content', null, 10, 5 );
//wh_filter( 'gform_field_input', null, 10, 5 );

define( 'WH_GF_INPUT_TYPES', ! class_exists( 'GFForms') ? array() : array(
    GF_Field_Text::class => 'text',
    GF_Field_Phone::class => 'text',
    GF_Field_Email::class => 'text',
    GF_Field_Checkbox::class => 'list',
) );

/**
 * @param string $choices
 * @param GF_Field|GF_Field_Checkbox|GF_Field_Radio $field
 *
 * @return string
 */
function wealthiher_filter_gform_field_choices( string $choices, GF_Field $field ) {
    
    if ( wh_gf_is_admin() ) {
        return $choices;
    }
    
    return $choices;
}

/**
 * @param string $field_container
 * @param GF_Field $field
 * @param array $form
 * @param string $css_class
 * @param string $style
 * @param string $field_content
 *
 * @return string
 */
function wealthiher_filter_gform_field_container( string $field_container, GF_Field $field, array $form, string $css_class, string $style, string $field_content ) {
    
    if ( wh_gf_is_admin() ) {
        return $field_container;
    }
    
    return '<div class="form-group">{FIELD_CONTENT}</div>';
}

/**
 * @param string $content
 * @param GF_Field $field
 * @param string $value
 * @param mixed $lead_id
 * @param int $form_id
 *
 * @return string
 */
function wealthiher_filter_gform_field_content( string $content, GF_Field $field, string $value = '', mixed $lead_id = 0, int $form_id = 0 ) {
    
    if ( wh_gf_is_admin() ) {
        return $content;
    }
    
    $format = $field->isRequired ? '<label for="input_%s">%s <span class="asterisk">*</span></label>{FIELD}' : '<label for="input_%s">%s</label>{FIELD}';
    
    $format = str_replace( '{FIELD}', GFCommon::get_field_input( $field, $value, $lead_id, $form_id ), $format );
    
    return sprintf( $format, $field->id, $field->get_field_label( false, $value ) );
}

/**
 * @param string $input
 * @param GF_Field $field
 * @param mixed $lead_id
 * @param string $value
 * @param int $form_id
 *
 * @return string
 */
function wealthiher_filter_gform_field_input( string $input, GF_Field $field, mixed $lead_id = 0, string $value = '', int $form_id = 0 ) {
    
    if ( wh_gf_is_admin() ) {
        return $input;
    }
    
    if ( 0 == $value ) {
        $value = '';
    }
    
    return match ( get_class( $field ) ) {
        GF_Field_Checkbox::class => sprintf( '<ul>%s</ul>', implode( $field->get_checkbox_choices( $value, 'disabled="disabled"', $form_id ) ) ),
        default => sprintf( '<input type="%1$s" name="input_%2$s" id="%2$s" placeholder="%3$s" value="%4$s">', $field->get_input_type(), $field->id, $field->get_placeholder_value( $field->placeholder ), $value ),
    };
}

function wh_gf_is_admin() {
    return is_admin() || GFCommon::is_form_editor() || GFCommon::is_entry_detail();
}