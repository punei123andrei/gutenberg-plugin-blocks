import { registerBlockType } from "@wordpress/blocks";
import {
    useBlockProps,
    InspectorControls
  } from "@wordpress/block-editor";
  import { __ } from "@wordpress/i18n";
  import { PanelBody, QueryControls, ColorPalette, FontSizePicker } from "@wordpress/components";
  import { useSelect } from "@wordpress/data";
  import icons from "../../icons.js";
  import "./main.css";

  registerBlockType("wp-riders/wr-application-form", {
    icon: {
        src: icons.primary,
    },
    edit ({ attributes, setAttributes }) {
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
       return (
        <>
            <div {...blockProps}>
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
  }
  
});