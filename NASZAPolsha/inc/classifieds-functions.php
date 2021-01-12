<?php

if (!function_exists('classifiedcategory_taxonomy')) :

    function classifiedcategory_taxonomy() {
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
            'rewrite' => true,
//            'rewrite' => array('slug' => 'classifieds'),
            'query_var' => true
        );

        register_taxonomy('classifiedcategory', 'classifieds', $args);
    }

endif;

add_action('init', 'classifiedcategory_taxonomy', 996);

if (!function_exists('classified_tag_taxonomy')) :

    function classified_tag_taxonomy() {
        $labels = array(
            'name' => 'Города',
            'singular_name' => 'Города',
            'search_items' => 'Поиск Города',
            'popular_items' => ( 'Популярные Города' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'Все Города',
            'edit_item' => 'Редактировать Город:',
            'update_item' => 'Обновить Город',
            'add_new_item' => 'Добавить новый Город',
            'new_item_name' => 'Новый Город имя',
            'menu_name' => 'Города',
            'view_item' => 'Посмотреть Города'
        );

        $args = array(
            'labels' => $labels,
            'rewrite' => true,
//            'rewrite' => array('slug' => 'classifieds/tags'),
            'hierarchical' => false,
            'query_var' => true
        );
		
		$object_type = array('classifieds', 'job');
		

        register_taxonomy('classified_tags', $object_type, $args);
    }

endif;

add_action('init', 'classified_tag_taxonomy', 997);

if (!function_exists('register_classified')) :

    function register_classified() {
        $labels = array(
            'name' => 'Оголошення',
            'singular_name' => 'Оголошення',
            'add_new' => 'Додати нове Оголошення',
            'add_new_item' => 'Додати нове Оголошення',
            'edit_item' => 'Редагувати Оголошення',
            'new item' => 'Нове Оголошення',
            'all_items' => 'Всі Оголошення',
            'view_item' => 'Переглянути Оголошення',
            'search_items' => 'Пошук Оголошення',
            'not_found' => 'Не знайдено',
            'not_found_in_trash' => 'В корзине нет Оголошення',
            'menu_name' => 'Оголошення'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('classifiedcategory', 'classified_tags'),
            'rewrite' => array('slug' => 'classifieds'),
//            'rewrite' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'author',
                'excerpt',
                'post-formats',
            ),
            'menu_icon' => 'dashicons-megaphone',
//            'menu_icon' => 'dashicons-awards',
            'menu_position' => 5,
        );
        register_post_type('classifieds', $args);
    }

endif;

add_action('init', 'register_classified', 998);

//add_action('init', 'classifieds_unregister_post_type', 999);

function classifieds_unregister_post_type() {
    unregister_post_type('classifieds');
}

//add_action( 'wp', 'unregister_classifiedcategory_taxonomy' );
function unregister_classifiedcategory_taxonomy() {
    // отменяем таксу только на отдельных страницах
    if (!is_singular())
        return;

    unregister_taxonomy('classifiedcategory');
}

// Add Theme Settings to CPT //
// Replace yourCPTslug with your CPT slug //
function classifieds_cpt_sq_metabox_general_settings($post_types) {
    $post_types[] = 'classifieds';
    return $post_types;
}

add_filter('sq_metabox_general_settings', 'classifieds_cpt_sq_metabox_general_settings');

//add_action('publish_post', 'insert_classifieds_meta');
//
//function insert_classifieds_meta($post_id){
//    if (!empty($post_id)) {
//        $post_id = $post_id;
//    } else {
//        global $post;
//        $post_id = $post->ID;
//    }
//    $slug = 'classifieds';
//    if ($slug != $_POST['post_type'] || $slug != get_post_type($post_id)) {
//        return;
//    } else {
//        
//    }
//}

add_action('publish_post', 'save_classifieds_meta', 10, 3);
//add_action('wp_insert_post', 'save_classifieds_meta', 10, 3);
//add_action('wp_update_post', 'save_classifieds_meta', 10, 3);
add_action('save_post', 'save_classifieds_meta', 10, 3);

function save_classifieds_meta($post_id) {
    if (!empty($post_id)) {
        $post_id = $post_id;
    } else {
        global $post;
        $post_id = $post->ID;
    }
    $slug = 'classifieds';
//    if ($slug != $_POST['post_type'] || $slug != get_post_type($post_id)) {
    if ($slug != get_post_type($post_id)) {
        return;
    } else {
        if (is_admin()) {
            $kleo_slider = get_post_meta($post_id, '_kleo_slider', true);
            $image_id = [];
            foreach ($metass as $image_url) {
                $image_id_get = max_get_image_id($image_url);
                if (!empty($image_id_get)) {
                    foreach ($image_id_get as $img_id) {
                        $image_id[] = $img_id;
                    }
                }
            }
            if (!empty($image_id)) {
                $upload = implode(",", $image_id);
                update_post_meta($post_id, 'upload', $upload);
            }
        } else {
            $kleo_slider = get_post_meta($post_id, '_kleo_slider', true);
            if (empty($kleo_slider)) {
                $upload = get_post_meta($post_id, 'upload', true);
                if (!empty($upload)) {
                    bf_save_classifieds_meta($post_id, $upload);
                }
            }
        }
    }
}

function bf_save_classifieds_meta($post_id, $upload) {
    $upload_a = explode(',', $upload);
    $kleo_slider = get_post_meta($post_id, '_kleo_slider', false);
    if (!empty($kleo_slider)) {
        $post_img = get_the_post_thumbnail_url($post_id);
        if (!in_array($post_img, $kleo_slider)) {
            $kleo_slider[] = $post_img;
        }
    } else {
        $kleo_slider[] = get_the_post_thumbnail_url($post_id);
    }
    foreach ($upload_a as $id) {
        $kleo_slider[] = wp_get_attachment_image_url($id);
    }
    update_post_meta($post_id, '_kleo_slider', $kleo_slider);
    return $kleo_slider;
}

function get_classified_tags($id) {
    $term_list = '';
    $terms = get_the_terms($id, 'classified_tags');
    if (!empty($terms) && !is_wp_error($terms)) {
        $count = count($terms);
        $i = 0;
        $term_list .= '<span class="classified_tags_media">';
        foreach ($terms as $term) {
            $i++;
            $term_list .= '<a href="' . get_term_link($term) . '" title="' . sprintf(__('View all post filed under %s', 'kleo'), $term->name) . '">' . $term->name . '</a>';
            if ($count != $i) {
                $term_list .= ' &middot; ';
            } else {
                $term_list .= '</span>';
            }
        }
    }
    return $term_list;
}

add_action('buddyforms_the_loop_item_title_after', 'entry_meta_buddyforms_the_loop_item', 10, 1);

//add_action('buddyforms_the_loop_item_excerpt_after', 'my_buddyforms_the_loop_item_last', 10, 1);

function entry_meta_buddyforms_the_loop_item($post_id) {
    echo '<span class="post-meta">';
    kleo_entry_meta(true, array(), $post_id);
    echo '</span>';
}
