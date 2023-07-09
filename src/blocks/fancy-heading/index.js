import { registerBlockType } from "@wordpress/blocks";
import block from "block.json";
import { __ } from "@wordpress/i18n"; 
import { RichText, useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ColorPalette } from '@wordpress/components';
import './main.css';

registerBlockType(block.name, {
    edit({ attributes, setAttributes }){
        const { content, underlineColor } = attributes;
        const blockProps = useBlockProps();
        return (
            <>
            <InspectorControls>
               <PanelBody title={__('Colors', 'self-development')}>
                    <ColorPalette 
                        colors={[
                            { name: 'Red', color: '#f87171' },
                            { name: 'Indigo', color: '#818cf8' }
                        ]}
                        value={underlineColor}
                        onChange={ newVal => setAttributes({ underlineColor: newVal })}
                    />
               </PanelBody>
            </InspectorControls>
            <div {...useBlockProps}>
            <RichText
            className="fancy-header"
             tagName="h2" 
             placeholder={__('Enter Heading', 'selfd-development')} 
             value={content}
             onChange={newVal => setAttributes({ content: newVal })}
             allowedFormats={['core/bold', 'core/italic']}
            />
            </div>
            </>
            );
    }, 
    save({ attributes }) {
        const { content, underlineColor } = attributes;
        const blockProps = useBlockProps.save({
            className: 'fancy-header',
            style: {
                'background-image': `
                linear-gradient(transparent, transparent),
                linear-gradient(${underlineColor}, ${underlineColor});
                `
            }
        });

        return (
            <RichText.Content
                {...blockProps}
                tagName="h2"
                value={content}
            />
            );
    }
});