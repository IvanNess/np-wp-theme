<?php

/**
 * Dop functions
 */
add_action('geodir_after_badge_on_image', 'gd_classified_tags_on_image');

function gd_classified_tags_on_image($post) {
    global $post;
    $terms = get_the_terms($post->id, 'gd_classified_tags');
    if (!empty($terms) && !is_wp_error($terms)) {
        $count = count($terms);
        $i = 0;
        $term_list = '<span class="classified_tags_media">';
        foreach ($terms as $term) {
            $i++;
            $term_list .= '<a href="' . get_term_link($term) . '" title="' . sprintf(__('View all post filed under %s', 'kleo'), $term->name) . '">' . $term->name . '</a>';
            if ($count != $i) {
                $term_list .= ' &middot; ';
            } else {
                $term_list .= '</span>';
            }
        }
        echo $term_list;
    }
}

//add_action( 'geodir_listing_slider_title', 'gd_classified_tags_on_image_slider' );
//
//function gd_classified_tags_on_image_slider($title_html, $post_id, $post_permalink, $post_title){
//    $terms = get_the_terms($post_id, 'gd_classified_tags');
//                                    if (!empty($terms) && !is_wp_error($terms)) {
//                                        $count = count($terms);
//                                        $i = 0;
//                                        $term_list = '<span class="classified_tags_media">';
//                                        foreach ($terms as $term) {
//                                            $i++;
//                                            $term_list .= '<a href="' . get_term_link($term) . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a>';
//                                            if ($count != $i) {
//                                                $term_list .= ' &middot; ';
//                                            } else {
//                                                $term_list .= '</span>';
//                                            }
//                                        }
//                                        return $title_html = $title_html.$term_list;
//                                    }
//}

function alert_geodir_actual_by_meta($id) {
    $content = '';
    $today_date = date('Y-m-d');
    $geodir_actual_by_meta = geodir_get_post_meta($id, 'geodir_actual_by', true);
    if (!empty($geodir_actual_by_meta) && $today_date > $geodir_actual_by_meta) {
        $content .= '<div class="alert alert-danger alert-dismissible fade in text-center pull-right" style="position: relative;">';
        $content .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="right: 10px;left: auto;">&times;</a>';
        $content .= '<strong> not relevant </strong>';
        $content .= '</div><div class="clearfix"></div>';
    }
    return $content;
}

?>