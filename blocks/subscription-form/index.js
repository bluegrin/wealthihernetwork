const { registerBlockType } = wp.blocks

import json from './block.json'
import Edit from './edit'
import { __wh } from '../../src/helpers'

const { name } = json

registerBlockType( name, {
    title: __wh( json.title ),
    edit: Edit,
} )