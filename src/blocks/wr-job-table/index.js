import { registerBlockType } from "@wordpress/blocks";
import {
    useBlockProps,
    InspectorControls
  } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, ColorPalette, FontSizePicker } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import icons from "../../icons.js";
import "./main.css";

registerBlockType("wp-riders/job-table", {
    icon: {
        src: icons.primary
    },
    edit ({ attributes, setAttributes }) {
        const { fontSize, bgEvenRow, textColor } = attributes;
        const blockProps = useBlockProps();
        const posts = useSelect((select) => {
            return select("core").getEntityRecords("postType", "wr-job-title", {
              per_page: 5,
              _embed: true,
            });
          });
          const fontSizes = [
            {
                name: __( 'Small', 'wp-riders' ),
                slug: 'small',
                size: 12,
            },
            {
              name: __('Medium', 'wp-riders'),
              slug: 'medium',
              size: 16
            },
            {
                name: __( 'Big', 'wp-riders' ),
                slug: 'big',
                size: 26,
            },
        ];
          const rowStyle = useBlockProps.save({
            className: 'rider-row',
            style: {
              'font-size': fontSize,
              'background-color': bgEvenRow,
              'color': textColor
            }
          });
          return (
            <>
            <InspectorControls>
                <PanelBody title={__('Font Size', 'wp-riders')}>
                <FontSizePicker
                  fontSizes={ fontSizes }
                  value={fontSize}
                  onChange={newVal => setAttributes({ fontSize: newVal })}
                      />
                </PanelBody>
                <PanelBody title={__('Border Color', 'wp-riders')}>
                <ColorPalette
                  colors={[
                    { name: 'rider-blue', color: '#0099ff' },
                    { name: 'plain', color: '#f9f9f9'}
                  ]}
                  value={bgEvenRow}
                  onChange={newVal => setAttributes({ bgEvenRow: newVal })}
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
                <div className="tableBlock">
                <table className="wr-table-sort">
                  {posts?.map((post, index) => {
                    const postTitle = post.title.rendered;
                    const skills = JSON.parse(post.meta.skills[0]);
                    const isEven = index % 2 === 0;
                    return (
                      <tr data-sort="ceva" {...(isEven && rowStyle)}>
                        <td className="post-title"><p>{postTitle}</p></td>
                        <td className="first-name"><p>{__("First Name", "wp_riders")}</p></td>
                        <td className="last-name"><p>{__("Last Name", "wp-riders")}</p></td>
                        <td className="skills"><p>{skills.join(", ")}</p></td>
                      </tr>
                    );
                  })}
                </table>
                </div>
            </div>
            </>
          );
    }
});
