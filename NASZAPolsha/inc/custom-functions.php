<?php

function print_a($a) {
    if (!empty($a)) {
        echo '<pre>';
        print_r($a);
        echo '</pre>';
    } else {
        echo 'empty value';
    }
}

function if_me($var) {
    $cur_user_id = get_current_user_id();
    if ($cur_user_id == 1) {
        print_a($var);
    }
}

function wpseo_fix_title_buddypress($title) {
    // Check if we are in a buddypress page 
    if (function_exists('buddypress') && buddypress()->displayed_user->id || buddypress()->current_component) {
        $bp_title_parts = bp_modify_document_title_parts();

        // let's rebuild the title here
        $title = $bp_title_parts['title'] . ' ' . $title;
    }
    return $title;
}

add_filter('wpseo_title', 'wpseo_fix_title_buddypress');

add_filter('the_content', 'insert_post_ads');

function insert_post_ads($content) {
    if (is_single() && 'post' == get_post_type()) {
        $banners_option = get_field('banners', 'option');
        $banners_array_priority = array();
        $banners_array_not_priority = array();
        foreach ($banners_option as $banner) {
            if (!empty($banner['priority']) && $banner['priority'] = 1) {
                $banners_array_priority[] = $banner;
            } else {
                $banners_array_not_priority[] = $banner;
            }
        }
        if (count($banners_array_priority) < 3) {
            shuffle($banners_array_not_priority);
            foreach ($banners_array_not_priority as $b) {
//                if (count($banners_array_priority) == 3) {
//                    break;
//                }
                $banners_array_priority[] = $b;
            }
        }
        $banners = $banners_array_priority;
        $ids1 = '';
        $links1 = '';
        $i1 = 0;
        foreach ($banners as $a1) {
            $i1++;
            if ($i1 == count($banners)) {
                $c1 = '';
            } else {
                $c1 = ',';
            }
            $ids1 .= $a1['image']['ID'] . $c1;
            $links1 .= $a1['link'] . $c1;
        }
        shuffle($banners);
        $ids2 = '';
        $links2 = '';
        $i2 = 0;
        foreach ($banners as $a2) {
            $i2++;
            if ($i2 == count($banners)) {
                $c2 = '';
            } else {
                $c2 = ',';
            }
            $ids2 .= $a2['image']['ID'] . $c2;
            $links2 .= $a2['link'] . $c2;
        }
        shuffle($banners);
        $ids3 = '';
        $links3 = '';
        $i3 = 0;
        foreach ($banners as $a3) {
            $i3++;
            if ($i3 == count($banners)) {
                $c3 = '';
            } else {
                $c3 = ',';
            }
            $ids3 .= $a3['image']['ID'] . $c3;
            $links3 .= $a3['link'] . $c3;
        }
        $id = get_the_ID();
        $args = array(
            'post__not_in' => array($id),
            'showposts' => 3,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $categories = get_the_category($id);

        if (!empty($categories)) {
            $category_ids = array();
            foreach ($categories as $rcat) {
                $category_ids[] = $rcat->term_id;
            }

            $args['category__in'] = $category_ids;
//        $args['orderby'] = 'date';
//        $args['order'] = 'DESC';
        }

        $posts = get_posts($args);
        $related_text = esc_html__("Related Articles", "kleo_framework");
        $content_link = [];
// Цикл
        foreach ($posts as $pst) {
            $content_link[] = '<p><em>Читайте також: <a href="' . get_permalink($pst->ID) . '">' . get_the_title($pst->ID) . '</a></em></p>';
        }
// Возвращаем оригинальные данные поста. Сбрасываем $post.
        wp_reset_postdata();
        if (check_paragraph_count($content) > 6) {
            $content = insert_after_paragraph($content_link[0], 1, $content);
            $content = insert_after_paragraph($content_link[1], 4, $content);
            $content = insert_after_paragraph($content_link[2], 6, $content);
        } elseif (check_paragraph_count($content) > 4) {
            $content = insert_after_paragraph($content_link[0], 2, $content);
            $content = insert_after_paragraph($content_link[1], 4, $content);
        } else {
            $content = insert_after_paragraph($content_link[0], 1, $content);
        }
        if (true) {
            $ad_code_1 = get_field('ad_code_1', 'option');
            $ad_code_2 = get_field('ad_code_2', 'option');
//            $ad_code_2 = do_shortcode('[vc_single_image image="22962" img_size="full" alignment="center" onclick="custom_link" img_link_target="_blank" el_class="easysend_banner_post" link="http://mikrealty.com.ua/prodaja/"]');
            $ad_code_3 = get_field('ad_code_3', 'option');
            if (check_paragraph_count($content) > 4) {
//            shuffle($banners);
//        $rand_banners = array_rand($banners, 3);
//            $ad_code_1 = '<p><a href="'.$banners[$rand_banners[0]]['link'].'" target="_blank"><img src="'.$banners[$rand_banners[0]]['image']['url'].'"></a></p>';
//
//            $ad_code_2 = '<p><a href="'.$banners[$rand_banners[1]]['link'].'" target="_blank"><img src="'.$banners[$rand_banners[1]]['image']['url'].'"></a></p>';
//
//            $ad_code_3 = '<p><a href="'.$banners[$rand_banners[2]]['link'].'" target="_blank"><img src="'.$banners[$rand_banners[2]]['image']['url'].'"></a></p>';
//            $ad_code_1 = '<p><a href="' . $banners[0]['link'] . '" target="_blank"><img src="' . $banners[0]['image']['url'] . '"></a></p>';
//            $ad_code_1 = '[vc_images_carousel images="' . $ids1 . '" img_size="full" onclick="custom_link" custom_links_target="_blank" autoplay="yes" hide_pagination_control="yes" scroll_fx="crossfade" min_items="1" max_items="1" custom_links="' . $links1 . '"]';
//            $ad_code_2 = '[vc_images_carousel images="' . $ids2 . '" img_size="full" onclick="custom_link" custom_links_target="_blank" autoplay="yes" hide_pagination_control="yes" scroll_fx="crossfade" min_items="1" max_items="1" custom_links="' . $links2 . '"]';
//            $ad_code_3 = '[vc_images_carousel images="' . $ids3 . '" img_size="full" onclick="custom_link" custom_links_target="_blank" autoplay="yes" hide_pagination_control="yes" scroll_fx="crossfade" min_items="1" max_items="1" custom_links="' . $links3 . '"]';
//            $ad_code_2 = '<p><a href="' . $banners[1]['link'] . '" target="_blank"><img src="' . $banners[1]['image']['url'] . '"></a></p>';
//            $ad_code_3 = '<p><a href="' . $banners[2]['link'] . '" target="_blank"><img src="' . $banners[2]['image']['url'] . '"></a></p>';
                $content = insert_after_paragraph($ad_code_2, 3, $content);
            } else {
//            $ad_code_1 = '<p><a href="' . $banners[0]['link'] . '" target="_blank"><img src="' . $banners[0]['image']['url'] . '"></a></p>';
//
//            $ad_code_3 = '<p><a href="' . $banners[1]['link'] . '" target="_blank"><img src="' . $banners[1]['image']['url'] . '"></a></p>';
//            $ad_code_1 = '[vc_images_carousel images="' . $ids1 . '" img_size="full" onclick="custom_link" custom_links_target="_blank" autoplay="yes" hide_pagination_control="yes" scroll_fx="crossfade" min_items="1" max_items="1" custom_links="' . $links1 . '"]';
//            $ad_code_3 = '[vc_images_carousel images="' . $ids3 . '" img_size="full" onclick="custom_link" custom_links_target="_blank" autoplay="yes" hide_pagination_control="yes" scroll_fx="crossfade" min_items="1" max_items="1" custom_links="' . $links3 . '"]';
            }
            $content = '<br>' . $ad_code_1 . $content . $ad_code_3 . '<br>';
        }
    }

    return $content;
}

function insert_after_paragraph($insertion, $paragraph_id, $content) {
    $closing_p = '</p>';
    $paragraphs = explode($closing_p, $content);
    foreach ($paragraphs as $index => $paragraph) {
        if (trim($paragraph)) {
            $paragraphs[$index] .= $closing_p;
        }

        if ($paragraph_id == $index + 1) {
            $paragraphs[$index] .= $insertion;
        }
    }

    return implode('', $paragraphs);
}

function check_paragraph_count($content) {
    global $post;
    if ($post->post_type == 'post') {
        $count = substr_count($content, '</p>');
        return $count;
    } else {
        return 0;
    }
}

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Настройки Сайта',
        'menu_title' => 'NASHAPolsha',
        'menu_slug' => 'nashapolsha-general-settings',
        'icon_url' => 'dashicons-welcome-widgets-menus',
        'position' => 3.6,
        'redirect' => false
    ));


    acf_add_options_sub_page(array(
        'page_title' => 'Настройки Рекламы',
        'menu_title' => 'Реклама',
        'parent_slug' => 'nashapolsha-general-settings',
        'menu_slug' => 'reklama-general-settings',
//        'icon_url' => 'dashicons-smiley',
//        'position' => 3.6,
//        'redirect' => false,
    ));
}

// retrieves the attachment ID from the file URL
function max_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
    return $attachment;
}

function new_job_view() {
    $new_view = false;
    $cur_user_id = get_current_user_id();
//    if ($cur_user_id == 1) {
    if (false) {
        $new_view = true;
    } else {
        $new_job_list_view = get_field('new_job_list_view', 'option');
        if (!empty($new_job_list_view) && $new_job_list_view == 1) {
            $only_amin = get_field('only_amin', 'option');
            if (!empty($only_amin) && $only_amin == 1) {
                if (current_user_can('administrator')) {
                    $new_view = true;
                } else {
                    $new_view = false;
                }
            } else {
                $new_view = true;
            }
        } else {
            $new_view = false;
        }
    }
    return $new_view;
}
