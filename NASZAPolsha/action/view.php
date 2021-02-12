<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php'); //load the wordpress environment, the wp-load.php file is at the root of the Wordpress directory structure
if (function_exists('get_post_custom')) { //check if it was loaded.
    global $wpdb;
    global $OFFSET; //get time zone settings

    $nowtime = gmdate('Y-m-d', time() + 3600 * $OFFSET); //current time generation
    $post_id = intval($_GET['views_id']); //initialize the variable with the post id.

    if ($post_id > 0) {
        $post_views = get_post_custom($post_id); //get Custom Fields
        $post_views_t = intval($post_views['views'][0]);
        // Lets try to update view counts. If not, then create such a field.
        if (!update_post_meta($post_id, 'views', ($post_views_t + 1))) {
            add_post_meta($post_id, 'views', 1, true);
        }

        $today_date = $post_views['tdate'][0];
        $today_views = intval($post_views['tviews'][0]);
        if (!$today_date) {
            add_post_meta($post_id, 'tdate', $nowtime, true);
        }
        //check the current date. if it matches, then update. if not, then copy it to yvies and set to zero.
        if ($today_date == $nowtime) {
            if (!update_post_meta($post_id, 'tviews', ($today_views + 1))) {
                add_post_meta($post_id, 'tviews', 1, true);
            }
        } else {
            if (!update_post_meta($post_id, 'yviews', $today_views)) {
                add_post_meta($post_id, 'yviews', $today_views, true);
            }
            update_post_meta($post_id, 'tviews', 1);
            update_post_meta($post_id, 'tdate', $nowtime);
        }
    }
}
?>
