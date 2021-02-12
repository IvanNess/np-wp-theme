<?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
if (isset($_POST)) {
    $current_time = current_time('Y-m-d H:i:s');
    $current_m = current_time('m.Y');
    if ($_POST['current_domain_user'] > 1) {
        $current_domain_user = $_POST['current_domain_user'];
    } else {
        $current_domain_user = 0;
    }
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'easysend_clicks_date',
                'value' => $current_m
            )
        ),
        'post_type' => 'easysend_clicks',
        'posts_per_page' => '1'
    );

    $posts = get_posts($args);
    if (!$posts || is_wp_error($posts)) {
        $easysend_click_m = false;
    }
    $easysend_click_m = $posts[0];
//    wp_reset_postdata();
    if ($easysend_click_m) {
        // Get the current value.
        $easysend_clicks_meta = get_field('easysend_clicks_meta', $easysend_click_m->ID);
        if (empty($easysend_clicks_meta)) {
            $easysend_clicks_meta = [];
        }
        $easysend_clicks_meta[] = [
            'url' => $_POST['url'],
            'href' => $_POST['href'],
            'name' => $_POST['name'],
            'date' => $current_time,
            'local' => $_POST['local'],
            'user' => $current_domain_user,
        ];
        update_field('easysend_clicks_meta', $easysend_clicks_meta, $easysend_click_m->ID);
    } else {
        $title = 'EasySend Clicks ' . $current_m;
        $post_data = array(
            'post_title' => $title,
            'post_type' => 'easysend_clicks',
            'post_status' => 'publish',
            'post_author' => $current_domain_user,
            'meta_input' => array(
                'easysend_clicks_date' => $current_m,
            ),
        );
        $post_id = wp_insert_post($post_data, true);
        if (is_wp_error($post_id)) {
            echo 'Could not record ' . $title;
        } else {
            echo 'Have a record! ' . $title;
            $easysend_clicks_meta = [];
            $easysend_clicks_meta[] = [
                'url' => $_POST['url'],
                'href' => $_POST['href'],
                'name' => $_POST['name'],
                'date' => $current_time,
                'local' => $_POST['local'],
                'user' => $current_user,
            ];
            update_field('easysend_clicks_meta', $easysend_clicks_meta, $post_id);
        }
    }
} else {
    echo 'post empty';
}