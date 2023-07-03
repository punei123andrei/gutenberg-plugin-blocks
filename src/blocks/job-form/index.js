import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, QueryControls, ColorPalette, FontSizePicker } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import icons from "../../icons.js";
import "./main.css";

registerBlockType("wp-riders/job-form", {
  icon: {
    src: icons.primary,
  },
  edit({ attributes, setAttributes }) {
    const { fontSize, borderBottomColor } = attributes;
    const blockProps = useBlockProps();

    const posts = useSelect((select) => {
      return select("core").getEntityRecords("postType", "wr-job-title", {
        per_page: 5,
        _embed: true,
      });
    });

    const mergedSkills = [];
    posts?.forEach((post) => {
    const skills = JSON.parse(post.meta.skills[0]);
    mergedSkills.push(...skills);
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
  
    const tableStyles = useBlockProps.save({
      style: {
        'font-size': fontSize,
        'border-bottom': `1px solid ${borderBottomColor}`,
        'width': '50%'
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
          { name: 'red', color: '#f87171' },
          { name: 'indigo', color: '#818cf8'}
        ]}
        value={borderBottomColor}
        onChange={newVal => setAttributes({ borderBottomColor: newVal })}
            />
      </PanelBody>
      </InspectorControls>
        <div {...blockProps}>
        <form className="wr-form wr-select-form" id="wr-sort">
        <label htmlFor="sortTable">{__('Select a skill', 'wp-riders')}</label>
        <select name="sortTable" id="sortTable">
        {mergedSkills?.map((skill) => {
            return <option vlaue={skill.replace(' ', '-')}>{skill}</option>;
        })}
        </select>
      </form>

      <div className="tableBlock">
      {posts?.map((post) => {
        const postTitle = post.title.rendered;
        const skills = JSON.parse(post.meta.skills[0]);
        return (
          <div className="container-flex x-auto" data-sort="ceva">
              <p {...tableStyles}>{postTitle}</p>
              <p {...tableStyles}>{skills.join(", ")}</p>
          </div>
        );
      })}
      </div>
          <form className="wr-form" id="wr-job-application">
            <label htmlFor="jobTitle">{__('Job Title', 'wp-riders')}</label>
            <select name="jobTitle" id="jobTitle">
            {mergedSkills?.map((skill) => {
              return <option vlaue={skill.replace(' ', '-')}>{skill}</option>;
          })}
            </select>

            <label htmlFor="firstName">{__('First Name', 'wp-riders')}</label>
            <input type="text" name="firstName" id="firstName" />

            <label htmlFor="lastName">{__('Last Name', 'wp-riders')}</label>
            <input type="text" name="lastName" id="lastName" />

            <label htmlFor="entryDate">{__('Entry Date', 'wp-riders')}</label>
            <input type="date" name="entryDate" id="entryDate" />

            <button type="submit">Submit</button>
        </form>
        </div>
      </>
    );
  },
});
