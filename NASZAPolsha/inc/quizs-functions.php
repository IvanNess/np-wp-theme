<?php

if (!function_exists('quizs_cat_taxonomy')) :

    function quizs_cat_taxonomy() {
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

        register_taxonomy('quizs_cat', 'quizs', $args);
    }

endif;

add_action('init', 'quizs_cat_taxonomy');

if (!function_exists('quizs_tag_taxonomy')) :

    function quizs_tag_taxonomy() {
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

        register_taxonomy('tag_quizs', 'quizs', $args);
    }

endif;

add_action('init', 'quizs_tag_taxonomy');

if (!function_exists('register_quizs')) :

    function register_quizs() {
        $labels = array(
            'name' => 'Тести',
            'singular_name' => 'Тест',
            'add_new' => 'Добавить новый Тест',
            'add_new_item' => 'Добавить новый Тест',
            'edit_item' => 'Редактировать Тест',
            'new item' => 'Новый Тест',
            'all_items' => 'Все Тести',
            'view_item' => 'Посмотреть Тест',
            'search_items' => 'Поиск Тести',
            'not_found' => 'Не найдено ни одного Теста',
            'not_found_in_trash' => 'В корзине нет Тестов',
            'menu_name' => 'Тести'
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
