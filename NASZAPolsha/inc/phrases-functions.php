<?php

if (!function_exists('phrases_cat_taxonomy')) :

    function phrases_cat_taxonomy() {
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

        register_taxonomy('phrases_cat', 'phrases', $args);
    }

endif;

add_action('init', 'phrases_cat_taxonomy');

if (!function_exists('phrases_tag_taxonomy')) :

    function phrases_tag_taxonomy() {
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

        register_taxonomy('tag_phrases', 'phrases', $args);
    }

endif;

add_action('init', 'phrases_tag_taxonomy');

if (!function_exists('register_phrases')) :

    function register_phrases() {
        $labels = array(
            'name' => 'Фразы',
            'singular_name' => 'Фраза',
            'add_new' => 'Добавить новую Фразу',
            'add_new_item' => 'Добавить новую Фразу',
            'edit_item' => 'Редактировать Фразу',
            'new item' => 'Новая Фраза',
            'all_items' => 'Все Фразы',
            'view_item' => 'Посмотреть Фразу',
            'search_items' => 'Поиск Фраз',
            'not_found' => 'Не найдено ни одной Фразы',
            'not_found_in_trash' => 'В корзине нет Фраз',
            'menu_name' => 'Фразы'
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
