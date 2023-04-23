const { SelectControl } = wp.components

import { __wh } from '../../src/helpers'

export default function Edit( { attributes, setAttributes } ) {

    console.log( {
        attributes: attributes,
        setAttributes: setAttributes,
    } )
    
    return (
        <SelectControl
            label={ __wh( 'MemberPress Form:' ) }
            value={ attributes.controllerAction }
            options={ [
                { label: __wh( 'Home' ), value: 'home' },
                { label: __wh( 'Password' ), value: 'password' },
                { label: __wh( 'Payments' ), value: 'payments' },
                { label: __wh( 'Subscriptions' ), value: 'subscriptions' },
            ] }
            onChange={ ( newControllerAction ) => setAttributes( { controllerAction: newControllerAction } ) }
        />
    )
}