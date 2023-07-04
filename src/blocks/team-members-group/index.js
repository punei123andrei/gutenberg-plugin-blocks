import { registerBlockType } from '@wordpress/blocks';
import { 
  useBlockProps, InspectorControls, InnerBlocks
} from '@wordpress/block-editor';
import {
  PanelBody, RangeControl, SelectControl
} from '@wordpress/components'
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js';
import './main.css';

registerBlockType('udemy-plus/team-members-group', {
  icon: {
    src: icons.primary
  },
  edit({ attributes, setAttributes }) {
    const { columns, imageShape } = attributes;
    const blockProps = useBlockProps({
      className: `cols-${columns}`
    });
   
    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Settings', 'udemy-plus')}>
            <RangeControl 
              label={__('Columns', 'udemy-plus')}
              onChange={columns => setAttributes({columns})}
              value={columns}
              min={2}
              max={4}
            />
            <SelectControl 
              label={__('Image Shape', 'udemy-plus')}
              value={ imageShape }
              options={[
                  { label: __('Hexagon', 'udemy-plus'), value: 'hexagon' },
                  { label: __('Rabbet', 'udemy-plus'), value: 'rabbet' },
                  { label: __('Pentagon', 'udemy-plus'), value: 'pentagon' },
              ]}
              onChange={imageShape => setAttributes({ imageShape })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <InnerBlocks 
          orientation="horizontal"
          allowedBlocks={[
            'udemy-plus/team-member'
          ]}
          template={[
            [
              'udemy-plus/team-member',
              {
                name: 'John Doe',
                title: 'CEO of Udemy',
                bio: 'This is an example of a bio'
              }
            ],
            ['udemy-plus/team-member'],
            ['udemy-plus/team-member'],
            // templateLock="all"
          ]}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { columns } = attributes;
    const blockProps = useBlockProps.save({
      className: `cols-${columns}`
    });
  
    return (
      <div {...blockProps}>
      <InnerBlocks.Content />
      </div>
    )
  }
});