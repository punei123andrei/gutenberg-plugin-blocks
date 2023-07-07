import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import { PanelBody } from "@wordpress/components";
import icons from "../../icons.js";
import "./main.css";

registerBlockType("wp-riders/wr-select", {
  icon: {
    src: icons.primary,
  },
  edit({ attributes, setAttributes }) {
    const { fontWeight } = attributes;
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

    const weightStyle = useBlockProps({
      style: {
        fontWeight: fontWeight,
      },
    });
    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Font weight", "wp-riders")}>
            <select
              value={fontWeight}
              onChange={(e) => setAttributes({ fontWeight: e.target.value })}
            >
              <option value="normal">Normal</option>
              <option value="bold">Bold</option>
              <option value="italic">Italic</option>
            </select>
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <form className="wr-form wr-select-form" id="wr-sort">
            <label htmlFor="sortTable" {...weightStyle}>
              {__("Select a skill", "wp-riders")}
            </label>
            <select name="sortTable" id="sortTable">
              {mergedSkills?.map((skill) => {
                return (
                  <option value={skill.replace(" ", "-")}>{skill}</option>
                );
              })}
            </select>
          </form>
        </div>
      </>
    );
  },
});