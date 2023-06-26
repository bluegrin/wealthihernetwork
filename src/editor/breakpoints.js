import {__wh} from "./helpers";

const { addFilter } = wp.hooks
const { useSetting, InspectorAdvancedControls } = wp.blockEditor
const { Fragment , useState } = wp.element;
const { createHigherOrderComponent } = wp.compose;
const { ToggleControl } = wp.components;

import classnames from 'classnames'
import Iframe from "@wordpress/block-editor/build/components/iframe";

addFilter( 'blocks.registerBlockType', 'wealthiher/custom-attributes', ( settings ) => {

    settings.attributes = Object.assign( settings.attributes, {
        showMobile: {
            type: 'boolean',
            default: true,
        },
        showTablet: {
            type: 'boolean',
            default: true,
        },
        showDesktop: {
            type: 'boolean',
            default: true,
        },
        showRetina: {
            type: 'boolean',
            default: true,
        },
    } )

    return settings
} )

const colorControl = createHigherOrderComponent( ( BlockEdit ) => {

    return ( props ) => {
        
        const { attributes, setAttributes } = props
        const { showMobile, showTablet, showDesktop, showRetina } = attributes

        return (
            <Fragment>
                <BlockEdit { ...props } />
                    <InspectorAdvancedControls>
                        <ToggleControl label={ __wh( 'Show on mobile' ) } checked={ showMobile } />
                        <ToggleControl label={ __wh( 'Show on tablet' ) } checked={ showMobile } />
                        <ToggleControl label={ __wh( 'Show on desktop' ) } checked={ showMobile } />
                        <ToggleControl label={ __wh( 'Show on retina' ) } checked={ showMobile } />
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
