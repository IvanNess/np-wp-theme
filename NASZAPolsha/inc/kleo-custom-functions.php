<?php

function kleo_entry_meta($echo = true, $att = array(), $post_id = '') {
    if (!empty($post_id)) {
        $post_id = $post_id;
    } else {
        $post_id = get_the_ID();
    }
    global $kleo_config;
    $meta_list = array();
    $author_links = '';
    $meta_elements = sq_option('blog_meta_elements', $kleo_config['blog_meta_defaults']);

    // Translators: used between list items, there is a space after the comma.
    if (in_array('categories', $meta_elements)) {
        $categories_list = get_the_category_list(__(', ', 'kleo_framework'));
    }

    // Translators: used between list items, there is a space after the comma.
    if (in_array('tags', $meta_elements)) {
        $tag_list = get_the_tag_list('', __(', ', 'kleo_framework'));
    }

    $date = sprintf('<a href="%1$s" rel="bookmark" class="post-time">' .
            '<time class="entry-date" datetime="%2$s">%3$s</time>' .
            '<time class="modify-date hide hidden updated" datetime="%4$s">%5$s</time>' .
            '</a>',
            esc_url(get_permalink()),
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_html(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
    );


    if (is_array($meta_elements) && !empty($meta_elements)) {


        if (in_array('author_link', $meta_elements) || in_array('avatar', $meta_elements)) {

            /* If buddypress is active then create a link to Buddypress profile instead */
            if (function_exists('bp_is_active')) {
                $author_link = esc_url(bp_core_get_userlink(get_the_author_meta('ID'), $no_anchor = false, $just_link = true));
                $author_title = esc_attr(sprintf(__('View %s\'s profile', 'kleo_framework'), get_the_author()));
            } else {
                $author_link = esc_url(get_author_posts_url(get_the_author_meta('ID')));
                $author_title = esc_attr(sprintf(__('View all POSTS by %s', 'kleo_framework'), get_the_author()));
            }

            $author = sprintf('<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s %4$s</a>',
                    $author_link,
                    $author_title,
                    in_array('avatar', $meta_elements) ? get_avatar(get_the_author_meta('ID'), 50) : '',
                    in_array('author_link', $meta_elements) ? '<span class="author-name">' . get_the_author() . '</span>' : ''
            );

            $meta_list[] = '<small class="meta-author author vcard">' . $author . '</small>';
        }

        if (function_exists('bp_is_active')) {
            if (in_array('profile', $meta_elements)) {
                $author_links .= '<a href="' . bp_core_get_userlink(get_the_author_meta('ID'), $no_anchor = false, $just_link = true) . '">' .
                        '<i class="icon-user-1 hover-tip" ' .
                        'data-original-title="' . esc_attr(sprintf(__('View profile', 'kleo_framework'), get_the_author())) . '"' .
                        'data-toggle="tooltip"' .
                        'data-placement="top"></i>' .
                        '</a>';
            }

            if (bp_is_active('messages') && is_user_logged_in()) {
                if (in_array('message', $meta_elements)) {
                    $author_links .= '<a href="' . wp_nonce_url(bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username(get_the_author_meta('ID'))) . '">' .
                            '<i class="icon-mail hover-tip" ' .
                            'data-original-title="' . esc_attr(sprintf(__('Contact %s', 'kleo_framework'), get_the_author())) . '" ' .
                            'data-toggle="tooltip" ' .
                            'data-placement="top"></i>' .
                            '</a>';
                }
            }
        }

        if (in_array('archive', $meta_elements)) {
            $author_links .= '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' .
                    '<i class="icon-docs hover-tip" ' .
                    'data-original-title="' . esc_attr(sprintf(__('View all posts by %s', 'kleo_framework'), get_the_author())) . '" ' .
                    'data-toggle="tooltip" ' .
                    'data-placement="top"></i>' .
                    '</a>';
        }
    }

    if ('' != $author_links) {
        $meta_list[] = '<small class="meta-links">' . $author_links . '</small>';
    }

    if (in_array('date', $meta_elements)) {
        $meta_list[] = '<small>' . $date . '</small>';
    }

    $cat_tag = array();

    if (isset($categories_list) && $categories_list) {
        $cat_tag[] = $categories_list;
    }

    if (isset($tag_list) && $tag_list) {
        $cat_tag[] = $tag_list;
    }
    if (!empty($cat_tag)) {
        $meta_list[] = '<small class="meta-category">' . implode(', ', $cat_tag) . '</small>';
    }

    //comments
    if ((!isset($att['comments']) || ( isset($att['comments']) && false != $att['comments'] ) ) && in_array('comments', $meta_elements)) {
        $meta_list[] = '<small class="meta-comment-count"><a href="' . get_permalink() . '#comments">' . get_comments_number() .
                ' <i class="icon-chat-1 hover-tip" ' .
                'data-original-title="' . sprintf(_n('This article has one comment', 'This article has %1$s comments', get_comments_number(), 'kleo_framework'), number_format_i18n(get_comments_number())) . '" ' .
                'data-toggle="tooltip" ' .
                'data-placement="top"></i>' .
                '</a></small>';
    }

    $meta_separator = isset($att['separator']) ? $att['separator'] : sq_option('blog_meta_sep', ', ');
    $output = '';
    if (get_post_type($post_id) == 'classifieds') {
        $actual_with = get_post_meta($post_id, 'actual_with', true);
        $actual_by = get_post_meta($post_id, 'actual_by', true);
        $phone = get_post_meta($post_id, 'phone', true);
        $email = get_post_meta($post_id, 'email', true);
        $today_date = current_time('Y-m-d');
        if (!empty($actual_by) && $today_date > $actual_by) {
            $output .= '<div class="hr-title hr-full hr-center hr-double" style="color: #fd3300;border-color: #fd3300;"><abbr><i class="icon-calendar-times-o"></i> не актуально</abbr></div>';
        }
        $output .= '<ul class="fontelo-list list-divider meta_classifieds_list" style="color:#444;">';
        if (!empty($actual_with)) {
            $output .= '<li><i class="icon-calendar-plus-o"></i> Data od: ' . date("d.m.Y", strtotime($actual_with)) . '</li>';
        }
        if (!empty($actual_by)) {
            $output .= '<li><i class="icon-calendar-minus-o"></i> Data do: ' . date("d.m.Y", strtotime($actual_by)) . '</li>';
        }
        $terms = get_the_terms($post_id, 'classifiedcategory');
        if (!empty($terms) && !is_wp_error($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '<li><i class="icon-angle-right"></i> Kategoria: ';
            foreach ($terms as $term) {
                $i++;
                $term_list .= '<a href="' . get_term_link($term) . '" style="color:#fd3300;" title="' . sprintf(__('View all post filed under %s', 'kleo'), $term->name) . '">' . $term->name . '</a>';
                if ($count != $i) {
                    $term_list .= ' &middot; ';
                } else {
                    $term_list .= '</li>';
                }
            }
            $output .= $term_list;
        }
        if (is_single()) {
            $tags = get_the_terms($post_id, 'classified_tags');
            if (!empty($tags) && !is_wp_error($tags)) {
                $count = count($tags);
                $i = 0;
                $tags_list = '<li><i class="icon-location"></i> Miasto: ';
                foreach ($tags as $term) {
                    $i++;
                    $tags_list .= '<a href="' . get_term_link($term) . '" style="color:#fd3300;" title="' . sprintf(__('View all post filed under %s', 'kleo'), $term->name) . '">' . $term->name . '</a>';
                    if ($count != $i) {
                        $tags_list .= ' &middot; ';
                    } else {
                        $tags_list .= '</li>';
                    }
                }
                $output .= $tags_list;
            }
            if (!empty($phone)) {
                $output .= '<li><div class="more_info_phone"><i class="icon-volume-control-phone"></i> Numer telefonu: <a href="tel:' . $phone . '" style="color:#fd3300;">' . $phone . '</a><span class="mask_phone">zadzwonić</span></div></li>';
            }
            if (!empty($email)) {
                $output .= '<li><div class="more_info_phone"><i class="icon-mail-alt"></i> Email: <a href="mailto:' . $email . '" style="color:#fd3300;">' . $email . '</a><span class="mask_email">napisz list</span></div></li>';
            }
        }
        $output .= '</ul>';
    }
    if ($echo) {
        if (get_post_type($post_id) == 'classifieds') {
            echo $output;
        } else {
            echo implode($meta_separator, $meta_list);
        }
    } else {
        if (get_post_type($post_id) == 'classifieds') {
            return $output;
        } else {
            return implode($meta_separator, $meta_list);
        }
    }
}
