const { registerBlockType } = wp.blocks

import metadata from './block.json'
import Edit from './edit'

console.log( metadata )

registerBlockType( metadata, {
    title: metadata.title,
    edit: Edit,
} )