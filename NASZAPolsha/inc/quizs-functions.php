<?php

if (!function_exists('quizs_cat_taxonomy')) :

    function quizs_cat_taxonomy() {
        $labels = array(
            'name' => 'Categories',
            'singular_name' => 'Category',
            'search_items' => 'Search Category',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category:',
            'edit_item' => 'Edit Category:',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add New Category',
            'new_item_name' => 'New Category name',
            'menu_name' => 'Categories',
            'view_item' => 'View Categories'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true
        );

        register_taxonomy('quizs_cat', 'quizs', $args);
    }

endif;

add_action('init', 'quizs_cat_taxonomy');

if (!function_exists('quizs_tag_taxonomy')) :

    function quizs_tag_taxonomy() {
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
            'add_new_item' => 'Add New Tag',
            'new_item_name' => 'New Tag name',
            'menu_name' => 'Tags',
            'view_item' => 'View Tags'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('tag_quizs', 'quizs', $args);
    }

endif;

add_action('init', 'quizs_tag_taxonomy');

if (!function_exists('register_quizs')) :

    function register_quizs() {
        $labels = array(
            'name' => 'Tests',
            'singular_name' => 'Test',
            'add_new' => 'Add New Test',
            'add_new_item' => 'Add New Test',
            'edit_item' => 'Edit Test',
            'new item' => 'New Test',
            'all_items' => 'All Tests',
            'view_item' => 'View Test',
            'search_items' => 'Search Tests',
            'not_found' => 'No Tests found',
            'not_found_in_trash' => 'There are no Tests in the trash',
            'menu_name' => 'Tests'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('quizs_cat', 'tag_quizs'),
            'rewrite' => array('slug' => 'quizs'),
            'hierarchical' => false,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ),
            'menu_icon' => 'dashicons-awards',
            'menu_position' => 5,
        );

        register_post_type('quizs', $args);
    }

endif;

add_action('init', 'register_quizs');
