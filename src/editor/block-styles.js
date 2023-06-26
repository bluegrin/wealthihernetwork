const { registerBlockStyle, unregisterBlockStyle } = wp.blocks;

import { __wh } from './helpers'

wp.domReady( () => {
    unregisterBlockStyle( 'core/image', 'rounded' )
    unregisterBlockStyle( 'core/button', 'fill' )
    unregisterBlockStyle( 'core/button', 'outline' )
} )

registerBlockStyle( 'core/heading', {
    name: 'plain',
    label: __wh( 'Plain' ),
} )

registerBlockStyle( 'core/heading', {
    name: 'fancy',
    label: __wh( 'Fancy' ),
} )

registerBlockStyle( 'core/image', {
    name: 'shadow-top-left',
    label: __wh( 'Shadow Top Left' ),
} )

registerBlockStyle( 'core/image', {
    name: 'shadow-bottom-left',
    label: __wh( 'Shadow Bottom Left' ),
} )

registerBlockStyle( 'core/image', {
    name: 'shadow-bottom-right',
    label: __wh( 'Shadow Bottom Right' ),
} )

registerBlockStyle( 'core/button', {
    name: 'primary',
    label: __wh( 'Primary' )
} )

registerBlockStyle( 'core/button', {
    name: 'secondary',
    label: __wh( 'Secondary' )
} )

registerBlockStyle( 'core/columns', {
    name: 'fluid',
    label: __wh( 'Fluid' ),
} )

registerBlockStyle( 'core/columns', {
    name: 'reverse',
    label: __wh( 'Mobile Reverse' ),
} )

registerBlockStyle( 'core/column', {
    name: 'spread',
    label: __wh( 'Spread' ),
} )

registerBlockStyle( 'core/group', {
    name: 'fluid',
    label: __wh( 'Fluid' ),
} )

registerBlockStyle( 'core/group', {
    name: 'callout',
    label: __wh( 'Callout' ),
} )

registerBlockStyle( 'core/cover', {
    name: 'fluid',
    label: __wh( 'Fluid' ),
} )
