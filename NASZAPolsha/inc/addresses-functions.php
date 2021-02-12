<?php

if (!function_exists('addresscategory_taxonomy')) :

    function addresscategory_taxonomy() {
        $labels = array(
            'name' => 'Categories',
            'singular_name' => 'Category',
            'search_items' => 'Category Search',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category:',
            'edit_item' => 'Edit Category:',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add a new Category',
            'new_item_name' => 'New Category Name',
            'menu_name' => 'Categories',
            'view_item' => 'View Categories'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true
        );

        register_taxonomy('addresscategory', 'addresses', $args);
    }

endif;

add_action('init', 'addresscategory_taxonomy');

if (!function_exists('addresses_tag_taxonomy')) :

    function addresses_tag_taxonomy() {
        $labels = array(
            'name' => 'Tags',
            'singular_name' => 'Tag',
            'search_items' => 'Tag Search',
            'popular_items' => ( 'Popular Tags' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'All Tags',
            'edit_item' => 'Edit Tag:',
            'update_item' => 'Update Tag',
            'add_new_item' => 'Add New Tag',
            'new_item_name' => 'New Tag Name',
            'menu_name' => 'Tags',
            'view_item' => 'View Tags'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('addresses_tags', 'addresses', $args);
    }

endif;

add_action('init', 'addresses_tag_taxonomy');

if (!function_exists('register_address')) :

    function register_address() {
        $labels = array(
            'name' => 'Important addresses',
            'singular_name' => 'Addresses',
            'add_new' => 'Add an address',
            'add_new_item' => 'Add a new address',
            'edit_item' => 'Edit address',
            'new item' => 'New address',
            'all_items' => 'All Important Addresses',
            'view_item' => 'View address',
            'search_items' => 'Adress Search',
            'not_found' => 'Not Found',
            'not_found_in_trash' => 'Not found in the trash',
            'menu_name' => 'Important addresses'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('addresscategory', 'addresses_tags'),
            'rewrite' => array('slug' => 'addresses'),
            'hierarchical' => false,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'post-formats',
            ),
            'menu_icon' => 'dashicons-location-alt',
            'menu_position' => 5,
        );
        register_post_type('addresses', $args);
    }
endif;

add_action('init', 'register_address');