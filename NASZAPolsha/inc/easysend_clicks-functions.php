<?php

if (!function_exists('easysend_clicks_local_taxonomy')) :

    function easysend_clicks_local_taxonomy() {
        $labels = array(
            'name' => 'Расположении',
            'singular_name' => 'Расположение',
            'search_items' => 'Поиск Расположении',
            'all_items' => 'Все Расположении',
            'parent_item' => 'Родительская Расположение:',
            'edit_item' => 'Редактировать Категорию:',
            'update_item' => 'Обновить Категорию',
            'add_new_item' => 'Добавить новую Категорию',
            'new_item_name' => 'Новая Расположение имя',
            'menu_name' => 'Расположении',
            'view_item' => 'Посмотреть Расположении'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true
        );

        register_taxonomy('easysend_clicks_local', 'easysend_clicks', $args);
    }

endif;

//add_action('init', 'easysend_clicks_local_taxonomy');

if (!function_exists('register_easysend_clicks')) :

function register_easysend_clicks() {
    register_post_type('easysend_clicks', array(
        'labels' => array(
            'name' => 'EasySend Clicks', // Основное название типа записи
            'singular_name' => 'EasySend Click', // отдельное название записи типа Book
            'add_new' => 'Add New',
            'add_new_item' => 'Add new EasySend Click',
            'edit_item' => 'Edit EasySend Click',
            'new_item' => 'New EasySend Click',
            'view_item' => 'See EasySend Click',
            'search_items' => 'Show EasySend Click',
            'not_found' => 'No partners found',
            'not_found_in_trash' => 'Not found in trash',
            'parent_item_colon' => '',
            'menu_name' => 'EasySend Clicks'
        ),
        'public' => true,
//        'taxonomies' => array('easysend_clicks_local'),
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-external',
        'supports' => array('title')
    ));
}

endif;

add_action('init', 'register_easysend_clicks');
