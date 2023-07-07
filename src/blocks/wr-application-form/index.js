import { registerBlockType } from "@wordpress/blocks";
import {
    useBlockProps,
    InspectorControls
  } from "@wordpress/block-editor";
  import { __ } from "@wordpress/i18n";
  import { PanelBody, ColorPalette } from "@wordpress/components";
  import { useSelect } from "@wordpress/data";
  import icons from "../../icons.js";
  import "./main.css";

  registerBlockType("wp-riders/wr-application-form", {
    icon: {
        src: icons.primary,
    },
    edit ({ attributes, setAttributes }) {
        const { bgColor, textColor } = attributes;
        const blockProps = useBlockProps();
        const posts = useSelect((select) => {
            return select("core").getEntityRecords("postType", "wr-job-title", {
              per_page: 5,
              _embed: true,
            });
          });
        const backgroundStyle = useBlockProps({
          style: {
            'background-color': bgColor,
            'color': textColor
          }
        });
       return (
        <>
            <InspectorControls>
            <PanelBody title={__('Border Color', 'wp-riders')}>
                    <ColorPalette
                      colors={[
                        { name: 'rider-blue', color: '#0099ff' },
                        { name: 'plain', color: '#f9f9f9'}
                      ]}
                      value={bgColor}
                      onChange={newVal => setAttributes({ bgColor: newVal })}
                          />
                    </PanelBody>
                    <PanelBody title={__('Text Color', 'wp-riders')}>
                    <ColorPalette
                      colors={[
                        { name: 'white', color: '#000' },
                        { name: 'black', color: '#fff'}
                      ]}
                      value={textColor}
                      onChange={newVal => setAttributes({ textColor: newVal })}
                          />
                    </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                <form className="wr-form" id="wr-job-application">
                    <label htmlFor="jobTitle">{__('Job Title', 'wp-riders')}</label>
                    <select name="jobTitle" id="jobTitle">
                    {posts?.map((post) => {
                      const postTitle = post.title.rendered;
                      return <option vlaue={postTitle}>{postTitle}</option>;
                    })}
                    </select>
                    <label htmlFor="firstName">{__('First Name', 'wp-riders')}</label>
                    <input type="text" name="firstName" id="firstName" />
                    <label htmlFor="lastName">{__('Last Name', 'wp-riders')}</label>
                    <input type="text" name="lastName" id="lastName" />
                    <label htmlFor="entryDate">{__('Entry Date', 'wp-riders')}</label>
                    <input type="date" name="entryDate" id="entryDate" />
                    <button {...backgroundStyle} type="submit">Submit</button>
                </form>
            </div>
        </>
       );
  }
  
});