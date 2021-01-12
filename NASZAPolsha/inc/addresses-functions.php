<?php

if (!function_exists('addresscategory_taxonomy')) :

    function addresscategory_taxonomy() {
        $labels = array(
            'name' => 'Категории',
            'singular_name' => 'Категория',
            'search_items' => 'Поиск Категории',
            'all_items' => 'Все Категории',
            'parent_item' => 'Родительская Категория:',
            'edit_item' => 'Редактировать Категорию:',
            'update_item' => 'Обновить Категорию',
            'add_new_item' => 'Добавить новую Категорию',
            'new_item_name' => 'Новая Категория имя',
            'menu_name' => 'Категории',
            'view_item' => 'Посмотреть Категории'
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
            'name' => 'Теги',
            'singular_name' => 'Тег',
            'search_items' => 'Поиск Теги',
            'popular_items' => ( 'Популярные Теги' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'Все Теги',
            'edit_item' => 'Редактировать Тег:',
            'update_item' => 'Обновить Тег',
            'add_new_item' => 'Добавить новый Тег',
            'new_item_name' => 'Новый Тег имя',
            'menu_name' => 'Теги',
            'view_item' => 'Посмотреть Теги'
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
            'name' => 'Важливі адреси',
            'singular_name' => 'Адреси',
            'add_new' => 'Додати адресу',
            'add_new_item' => 'Додати нову адресу',
            'edit_item' => 'Редагувати адресу',
            'new item' => 'Нова адреса',
            'all_items' => 'Всі Важливі адреси',
            'view_item' => 'Переглянути адрес',
            'search_items' => 'Пошук адреси',
            'not_found' => 'Не знайдено',
            'not_found_in_trash' => 'Не знайшли в смітнику',
            'menu_name' => 'Важливі адреси'
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