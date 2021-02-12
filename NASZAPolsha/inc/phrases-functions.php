<?php

if (!function_exists('phrases_cat_taxonomy')) :

    function phrases_cat_taxonomy() {
        $labels = array(
            'name' => 'Categories',
            'singular_name' => 'Category',
            'search_items' => 'Search Category',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category:',
            'edit_item' => 'Edit Category:',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add new Category',
            'new_item_name' => 'New Category name',
            'menu_name' => 'Categories',
            'view_item' => 'View Categories'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true
        );

        register_taxonomy('phrases_cat', 'phrases', $args);
    }

endif;

add_action('init', 'phrases_cat_taxonomy');

if (!function_exists('phrases_tag_taxonomy')) :

    function phrases_tag_taxonomy() {
        $labels = array(
            'name' => 'Tags',
            'singular_name' => 'Tag',
            'search_items' => 'Search Tags',
            'popular_items' => ( 'Popular Tags' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'All Tags',
            'edit_item' => 'Edit Tag:',
            'update_item' => 'Update Tag',
            'add_new_item' => 'Add new Tag',
            'new_item_name' => 'New Tag name',
            'menu_name' => 'Tags',
            'view_item' => 'View Tags'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('tag_phrases', 'phrases', $args);
    }

endif;

add_action('init', 'phrases_tag_taxonomy');

if (!function_exists('register_phrases')) :

    function register_phrases() {
        $labels = array(
            'name' => 'Phrases',
            'singular_name' => 'Phrase',
            'add_new' => 'Add new Phrase',
            'add_new_item' => 'Add new Phrase',
            'edit_item' => 'Edit Phrase',
            'new item' => 'New Phrase',
            'all_items' => 'All Phrases',
            'view_item' => 'View Phrase',
            'search_items' => 'Search Phrases',
            'not_found' => 'No Phrases found',
            'not_found_in_trash' => 'There are no Phrases in the trash',
            'menu_name' => 'Phrases'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('phrases_cat', 'tag_phrases'),
            'rewrite' => array('slug' => 'phrases'),
            'hierarchical' => false,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'post-formats',
            ),
            'menu_icon' => 'dashicons-playlist-audio',
            'menu_position' => 5,
        );

        register_post_type('phrases', $args);
    }

endif;

add_action('init', 'register_phrases');

add_action('save_post', 'phrases_fun');

function phrases_fun($post_id) {
    if (get_post_type() == 'phrases') {
        if (!wp_is_post_revision($post_id)) {
            $meta_value = get_post_meta($post_id, 'phrases', true);
            if (!empty($meta_value)) {
                update_post_meta($post_id, $meta_key = '_kleo_post_media_status', '1');
                update_post_meta($post_id, $meta_key = '_kleo_audio', $meta_value);
            }
        }
    }
}
