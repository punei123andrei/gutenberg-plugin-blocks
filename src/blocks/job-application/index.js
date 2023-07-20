import { registerBlockType } from '@wordpress/blocks';
import { 
  useBlockProps, InnerBlocks
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js';

registerBlockType("wp-riders/job-application", {
    icon: {
        src: icons.primary
    },
    edit ({ attributes, setAttributes }) {
        const blockProps = useBlockProps();
        return (
            <>
                <div {...useBlockProps}>
                    <InnerBlocks 
                        orientation="vertical"
                        allowedBlocks={[
                            'wp-riders/wr-select',
                            'wp-riders/job-table',
                            'wp-riders/wr-application-form'
                        ]}
                        template={[
                            ['wp-riders/wr-select'],
                            ['wp-riders/job-table'],
                            ['wp-riders/wr-application-form']
                        ]}
                        templateLock="insert"
                    />
                </div>
            </>
        );
    },
    save () {
        const blockProps = useBlockProps.save();
        return (
            <div {...blockProps}>
                <InnerBlocks.Content />
            </div>
        );
    }
});