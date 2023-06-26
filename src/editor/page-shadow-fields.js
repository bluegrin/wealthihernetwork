const { assign } = lodash
const { addFilter } = wp.hooks
const { Fragment, useState } = wp.element
const { createHigherOrderComponent } = wp.compose
const { InspectorControls } = wp.editor
const { PanelBody, PanelRow, RadioControl, TextControl, BaseControl, ColorPalette } = wp.components
const { useSetting, getColorObjectByColorValue, getColorObjectByAttributeValues } = wp.blockEditor

import { __wh } from './helpers'

const isValidBlockType = ( name ) => {
    return ['core/group', 'core/columns', 'core/column', 'core/image', 'core/quote' ].includes( name )
}

export const addMyCustomBlockControls = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {

        if ( ! isValidBlockType( props.name ) || ! props.isSelected ) {
            return <BlockEdit { ...props } />
        }

        const palette = useSetting( 'color.palette' )
        const [ option, setOption ] = useState( 'none' )

        return (
            <Fragment>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <PanelBody title={ __wh( 'Block Shadow' ) }>
                        <PanelRow>
                            <RadioControl
                                label={ __wh( 'Shadow Position' ) }
                                selected={ option }
                                options={ [
                                    { label: 'None', value: 'none' },
                                    { label: 'Top Right', value: 'top-right' },
                                    { label: 'Bottom Right', value: 'bottom-right' },
                                    { label: 'Bottom Left', value: 'bottom-left' },
                                    { label: 'Top Left', value: 'top-left' },
                                ] }
                                onChange={ ( value ) => setOption( value ) }
                            />
                        </PanelRow>
                        <PanelRow>
                            <BaseControl label={ __wh( 'Shadow Color' ) }>
                                <ColorPalette
                                    value={ getColorObjectByAttributeValues( palette, props.attributes.shadowColor ).color }
                                    colors={ [ ...palette ] }
                                    disableCustomColors={ true }
                                    onChange={ ( value ) => {
                                        props.setAttributes( { shadowColor: getColorObjectByColorValue( palette, value ).slug } )
                                    } }
                                />
                            </BaseControl>
                        </PanelRow>
                        <TextControl
                            label={ __wh( 'My Custom Control' ) }
                            help={ __wh( 'Some help text for my custom control.' ) }
                            value={ props.attributes.scheduledStart || '' }
                            onChange={ ( nextValue ) => {
                                props.setAttributes( {
                                    scheduledStart: nextValue,
                                } )
                            } } />
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        )
   }
}, 'addMyCustomBlockControls' )

addFilter( 'editor.BlockEdit', 'wealthiher/block-shadow-control', addMyCustomBlockControls )

export function addAttribute( settings ) {

    if ( isValidBlockType( settings.name ) ) {
        settings.attributes = assign( settings.attributes, {
            shadowPosition: {
                type: 'string',
            },
            shadowColor: {
                type: 'string',
            },
        } )
    }

    return settings
}

export function addSaveProps( extraProps, blockType, attributes ) {

    if ( isValidBlockType( blockType.name ) ) {
        extraProps.shadowPosition = attributes.shadowPosition
        extraProps.shadowColor = attributes.shadowColor
    }

    return extraProps
}

addFilter( 'blocks.registerBlockType', 'wealthiher/block-shadow-add-attr', addAttribute )
addFilter( 'blocks.getSaveContent.extraProps', 'wealthiher/block-shadow-add-props', addSaveProps )
