const { compose } = wp.compose
const { withSelect, withDispatch, useSelect } = wp.data
const { useSetting, getColorObjectByColorValue, getColorObjectByAttributeValues } = wp.blockEditor
const { PluginDocumentSettingPanel } = wp.editPost
const { BaseControl, ColorPalette, PanelRow, SelectControl, Spinner } = wp.components

import { __wh } from './helpers'

const Component = ( { postType, postMeta, setPostMeta } ) => {
    
    if ( 'page' !== postType ) return null

    const palette = useSetting( 'color.palette' )
    const menuOptions = [ { value: 0, label: 'None' } ]
    
    const menus = useSelect( ( select ) => {
        return select( 'core' ).getEntityRecords( 'taxonomy', 'nav_menu' )
    } )

    const isMenusLoading = useSelect( ( select ) => {
        return select( 'core' ).isResolving( 'core', 'getEntityRecords', [ 'taxonomy', 'nav_menu' ] )
    } )

    if ( ! isMenusLoading && menus ) {
        menus.forEach( ( menu ) => {
            menuOptions.push( { value: menu.id, label: menu.name } )
        } )
    }

    return(
        <PluginDocumentSettingPanel title={ __wh( 'Secondary Menu') } icon=" " initialOpen="false">
            <PanelRow>
                { ( isMenusLoading ) ? (
                    <Spinner />
                ) : (
                    <SelectControl
                        label={ __wh( 'Secondary Menu' ) }
                        value={ postMeta.wh_menu }
                        options={ menuOptions }
                        onChange={ ( value ) => setPostMeta( { wh_menu: value } ) }
                    />
                ) }
            </PanelRow>
            <PanelRow>
                <BaseControl label={ __wh( 'Background Color' ) }>
                    <ColorPalette
                        value={ getColorObjectByAttributeValues( palette, postMeta.wh_menu_color ).color }
                        colors={ [ ...palette ] }
                        disableCustomColors={ true }
                        onChange={ ( value ) => {
                            setPostMeta( { wh_menu_color: getColorObjectByColorValue( palette, value ).slug } )
                        } }
                    />
                </BaseControl>
            </PanelRow>
        </PluginDocumentSettingPanel>
    )
}

export default compose( [
    withSelect( ( select ) => {
        return {
            postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
            postType: select( 'core/editor' ).getCurrentPostType(),
        }
    } ),
    withDispatch( ( dispatch ) => {
        return {
            setPostMeta( newMeta ) {
                dispatch( 'core/editor' ).editPost( { meta: newMeta } )
            }
        }
    } )
] )( Component )