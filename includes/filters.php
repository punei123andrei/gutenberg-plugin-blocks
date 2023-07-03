<?php 

function hide_meta_boxes() {
    remove_meta_box('postcustom', 'wr-job-title', 'normal');
}