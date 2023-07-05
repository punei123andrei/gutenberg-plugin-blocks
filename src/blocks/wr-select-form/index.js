import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import icons from "../../icons.js";
import "./main.css";

  registerBlockType("wp-riders/wr-select", {
    icon: {
        src: icons.primary,
      },
      edit () {
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
                <form className="wr-form wr-select-form" id="wr-sort">
                    <label htmlFor="sortTable">{__('Select a skill', 'wp-riders')}</label>
                    <select name="sortTable" id="sortTable">
                    {mergedSkills?.map((skill) => {
                        return <option vlaue={skill.replace(' ', '-')}>{skill}</option>;
                    })}
                    </select>
                </form>
            </div>
            </>
          );
      }
  });