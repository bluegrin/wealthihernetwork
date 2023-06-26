import { useBlockProps, RichText } from '@wordpress/block-editor';
import './editor.scss';

import { __wh } from '../../editor/helpers'

export default function Edit( { attributes, setAttributes } ) {
    const { title, subtitle } = attributes;
    return (
        <>
            <RichText
                { ...useBlockProps() }
                onChange={ ( subtitle ) => setAttributes( { text: subtitle } ) }
                value={ text }
                placeholder={ __wh( 'Subtitle' ) }
            />
            <RichText
                { ...useBlockProps() }
                onChange={ ( title ) => setAttributes( { text: title } ) }
                value={ text }
                placeholder={ __wh( 'Title' ) }
            />
        </>
    );
}