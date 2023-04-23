import {__wh} from "./helpers";

const { addFilter } = wp.hooks
const { getColorObjectByColorValue, getColorObjectByAttributeValues, useSetting, InspectorAdvancedControls } = wp.blockEditor
const { Fragment }	= wp.element;
// const { InspectorAdvancedControls }	= wp.editor;
const { createHigherOrderComponent } = wp.compose;
const { BaseControl, ColorPalette } = wp.components;

import classnames from 'classnames'
import Iframe from "@wordpress/block-editor/build/components/iframe";

addFilter( 'blocks.registerBlockType', 'wealthiher/custom-attributes', ( settings ) => {

    if ( 'core/image' !== settings.name ) return settings

    settings.attributes = Object.assign( settings.attributes, {
        shadowColor: {
            type: 'boolean',
            default: '',
        }
    } )

    return settings
} )

const colorControl = createHigherOrderComponent( ( BlockEdit ) => {

    return ( props ) => {
        
        const { attributes, setAttributes } = props
        const { shadowColor } = attributes
        const palette = useSetting( 'color.palette' )

        return (
            <Fragment>
                <BlockEdit { ...props } />
                    <InspectorAdvancedControls>
                        <BaseControl label={ __wh( 'Shadow Color' ) }>
                            <ColorPalette
                                value={ getColorObjectByAttributeValues( palette, shadowColor ).color }
                                colors={ [...palette] }
                                disableCustomColors={ true }
                                onChange={ ( value ) => setAttributes( { shadowColor: getColorObjectByColorValue( palette, value).slug } ) }
                            />
                        </BaseControl>
                    </InspectorAdvancedControls>
            </Fragment>
        )
        
    }
} )
addFilter( 'editor.BlockEdit', 'wealthiher/custom-control',  colorControl )

addFilter( 'blocks.getSaveContent.extraProps', 'wealthiher/custom-class', ( extraProps, blockType, attributes ) => {

    if ( 'core/image' !== blockType.name ) return extraProps
    
    const { shadowColor } = attributes
    
    if ( shadowColor &&  typeof shadowColor !== 'undefined' ) {
        extraProps.className = classnames(extraProps.className, `shadow-color-${shadowColor}`)
    }
    
    return extraProps
} )
