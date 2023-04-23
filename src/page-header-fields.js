const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data
const { useSetting, getColorObjectByColorValue, getColorObjectByAttributeValues } = wp.blockEditor
const { PluginDocumentSettingPanel } = wp.editPost
const { BaseControl, TextControl, ToggleControl, ColorPalette, PanelRow } = wp.components

import { __wh } from './helpers'

const Component = ( { postType, postMeta, setPostMeta } ) => {
    
    if ( 'page' !== postType ) return null
    
    const palette = useSetting( 'color.palette' )
    
    return(
        <PluginDocumentSettingPanel title={ __wh( 'Page Header') } icon=" " initialOpen="false">
            <PanelRow>
                <TextControl
                    label={ __wh( 'Title' ) }
                    value={ postMeta.wh_title }
                    onChange={ ( value ) => setPostMeta( { wh_title: value } ) }
                />
            </PanelRow>
            <PanelRow>
                <TextControl
                    label={ __wh( 'Subtitle' ) }
                    value={ postMeta.wh_subtitle }
                    onChange={ ( value ) => setPostMeta( { wh_subtitle: value } ) }
                />
            </PanelRow>
            <PanelRow>
                <BaseControl label={ __wh( 'Background Color' ) }>
                    <ColorPalette
                        value={ getColorObjectByAttributeValues( palette, postMeta.wh_header_color ).color }
                        colors={ [ ...palette ] }
                        disableCustomColors={ true }
                        onChange={ ( value ) => {
                            setPostMeta({wh_header_color: getColorObjectByColorValue(palette, value).slug})
                        } }
                    />
                </BaseControl>
            </PanelRow>
            <PanelRow>
                <ToggleControl
                    label={ __wh( 'Wavy Top Edge' ) }
                    checked={ postMeta.wh_header_waves_top }
                    onChange={ ( value ) => setPostMeta( { wh_header_waves_top: value } ) }
                />
            </PanelRow>
            <PanelRow>
                <ToggleControl
                    label={ __wh( 'Wavy Bottom Edge' ) }
                    checked={ postMeta.wh_header_waves_bottom }
                    onChange={ ( value ) => setPostMeta( { wh_header_waves_bottom: value } ) }
                />
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