const { useBlockProps } = wp.blockEditor

import { __wh } from '../../editor/helpers'

export default function Edit() {
    return (
        <p { ...useBlockProps() }>
            { __wh( 'Partners Carousel' ) }
        </p>
    )
}