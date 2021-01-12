<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// classifieds
if (isset($_GET['classifieds'])) {
    $args = array(
        'post_type' => 'classifieds',
        'showposts' => -1,
        'orderby' => 'date',
        'order' => 'ASC', //DESC
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
    );
    query_posts($args);
    if (have_posts()) :
        while (have_posts()) : the_post();
            $i++;
            $id = get_the_ID();
            set_post_format($id, 'gallery');
            echo $id . '<br>';
        endwhile;
        // Reset Query
        wp_reset_query();
    endif;
} elseif (isset($_GET['gd_classified'])) {
    $args = array(
        'post_type' => 'gd_classified',
        'showposts' => 100,
        'orderby' => 'date',
        'order' => 'DESC', //DESC || ASC
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
    );
    query_posts($args);
    global $wp_query;
    echo $wp_query->found_posts . '<br>';
    if (have_posts()) :
        while (have_posts()) : the_post();
            $id = get_the_ID();
            $title = get_the_title();
            $ppp = get_page_by_title($title, 'OBJECT', 'classifieds');
            $metas = geodir_get_post_info($id);
            $post_images = geodir_get_images($id);
            $img_array = [];
            $kleo_slider = [];
            $kleo_slider[] = get_the_post_thumbnail_url($id);
            if (!empty($post_images)) {
                foreach ($post_images as $k => $v) {
                    $img_array[] = $v->id;
                    $kleo_slider[] = $v->src;
                }
            } else {
                $img_array[] = get_post_thumbnail_id($id);
            }
            $upload = implode(",", $img_array);
            if (!empty($ppp) || $ppp != null) {
                $post_id = $ppp->ID;
                echo $post_id;
                $thumbnail_id = get_post_thumbnail_id($id);
                if (!empty($thumbnail_id)) {
                    if (set_post_thumbnail($post_id, $thumbnail_id))
                        echo 'Миниатюра установлена.';
                    else
                        echo 'Миниатюра удалена.';
                }
                $arg = array(
                    'ID' => $post_id,
                    'post_author' => $metas->post_author,
                );
                wp_update_post($arg);
                update_post_meta($post_id, 'actual_with', $metas->geodir_actual_with);
                update_post_meta($post_id, 'actual_by', $metas->geodir_actual_by);
                update_post_meta($post_id, 'phone', $metas->geodir_contact);
                update_post_meta($post_id, 'email', $metas->geodir_email);
                update_post_meta($post_id, 'upload', $upload);
                update_post_meta($post_id, '_kleo_slider', $kleo_slider);
                print_a($img_array);
//                print_a($metas);
//                print_a($post_images);
            } else {
                echo 'нет поста ' . $title . '<br>';
                $post_data = array(
                    'post_title' => $title,
                    'post_content' => $metas->post_content,
                    'post_status' => 'publish',
                    'post_author' => $metas->post_author,
                    'post_date' => $metas->post_date, // Время, когда запись была создана.
                    'post_date_gmt' => $metas->post_date_gmt,
                    'post_name' => $metas->post_name,
                    'post_type' => 'classifieds',
                    'meta_input' => array(
                        'actual_with' => $metas->geodir_actual_with,
                        'actual_by' => $metas->geodir_actual_by,
                        'phone' => $metas->geodir_contact,
                        'email' => $metas->geodir_email,
                        '_kleo_slider' => $kleo_slider,
                        'upload' => $upload,
                    ),
                );
                $post_ids = wp_insert_post($post_data, true);

                if (is_wp_error($post_ids)) {
                    echo $post_ids->get_error_message();
                } else {
                    if (!empty($img_array)) {
                        if (set_post_thumbnail($post_ids, $img_array[0]->id))
                            echo 'Миниатюра установлена.';
                        else
                            echo 'Миниатюра удалена.';
                    }
                    wp_set_post_terms($post_ids, $metas->geodir_city, 'classified_tags');
                    $gd_classifiedcategory = get_term_by('id', $metas->default_category, 'gd_classifiedcategory');
                    $classifiedcategory = get_term_by('name', $gd_classifiedcategory->name, 'classifiedcategory');
                    wp_set_post_terms($post_ids, $classifiedcategory->term_id, 'classifiedcategory');
                }
            }
        endwhile;
        wp_reset_query();
    endif;
} elseif (isset($_GET['job_listing'])) {
    $args = array(
        'post_type' => 'job_listing',
        'showposts' => -1,
        'orderby' => 'date',
        'order' => 'ASC', //DESC || ASC
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'expired')
    );
    query_posts($args);
    global $wp_query;
    echo $wp_query->found_posts . '<br>';
    if (have_posts()) :
        while (have_posts()) : the_post();
            $id = get_the_ID();
            $title = get_the_title();
            $ppp = get_page_by_title($title, 'OBJECT', 'job');
            $get_post_meta = get_post_meta($id);
            $metas = get_post($id);
            print_a($metas);
//            if (!empty($ppp) || $ppp != null) {
//                $post_id = $ppp->ID;
//                echo $post_id . '<br>';
//                $thumbnail_id = get_post_thumbnail_id($id);
//                if (!empty($thumbnail_id)) {
//                    if (set_post_thumbnail($post_id, $thumbnail_id))
//                        echo 'Миниатюра установлена.<br>';
//                    else
//                        echo 'Миниатюра удалена.<br>';
//                }
//                $arg = array(
//                    'ID' => $post_id,
//                    'post_author' => $metas->post_author,
//                );
//                wp_update_post($arg);
//                update_post_meta($post_id, 'email', $get_post_meta['_application'][0]);
//                update_post_meta($post_id, '_job_location', $get_post_meta['_job_location'][0]);
//                update_post_meta($post_id, '_job_expires', $get_post_meta['_job_expires'][0]);
//                update_post_meta($post_id, '_job_salary', $get_post_meta['_job_salary'][0]);
//                update_post_meta($post_id, '_company_name', $get_post_meta['_company_name'][0]);
//                update_post_meta($post_id, '_company_website', $get_post_meta['_company_website'][0]);
//                update_post_meta($post_id, '_company_tagline', $get_post_meta['_company_tagline'][0]);
//                update_post_meta($post_id, '_thumbnail_id', $get_post_meta['_thumbnail_id'][0]);
//                update_post_meta($post_id, 'great_logo_of_the_company', $get_post_meta['great_logo_of_the_company'][0]);
//                echo 'update ' . $title . '<br>';
//            } else {
//                echo 'нет поста ' . $title . '<br>';
//                $post_data = array(
//                    'post_title' => $title,
//                    'post_content' => $metas->post_content,
//                    'post_status' => 'publish',
//                    'post_author' => $metas->post_author,
//                    'post_date' => $metas->post_date, // Время, когда запись была создана.
//                    'post_date_gmt' => $metas->post_date_gmt,
//                    'post_name' => $metas->post_name,
//                    'post_type' => 'job',
//                    'meta_input' => array(
//                        'email' => $get_post_meta['_application'][0],
//                        '_job_location' => $get_post_meta['_job_location'][0],
//                        '_job_expires' => $get_post_meta['_job_expires'][0],
//                        '_job_salary' => $get_post_meta['_job_salary'][0],
//                        '_company_name' => $get_post_meta['_company_name'][0],
//                        '_company_website' => $get_post_meta['_company_website'][0],
//                        '_company_tagline' => $get_post_meta['_company_tagline'][0],
//                        '_thumbnail_id' => $get_post_meta['_thumbnail_id'][0],
//                        'great_logo_of_the_company' => $get_post_meta['great_logo_of_the_company'][0],
//                    ),
//                );
//                $post_ids = wp_insert_post($post_data, true);
//
//                if (is_wp_error($post_ids)) {
//                    echo $post_ids->get_error_message() . '<br>';
//                } else {
//                    echo 'insert ' . $title . '<br>';
//                }
//            }
        endwhile;
        wp_reset_query();
    endif;
 }elseif (isset($_GET['job'])) {
    $args = array(
        'post_type' => 'job',
        'showposts' => -1,
        'orderby' => 'date',
        'order' => 'ASC', //DESC || ASC
        'post_status' => array('expired')
    );
    query_posts($args);
    global $wp_query;
    echo $wp_query->found_posts . '<br>';
    if (have_posts()) :
        while (have_posts()) : the_post();
            $id = get_the_ID();
            $title = get_the_title();
            $ppp = get_page_by_title($title, 'OBJECT', 'job');
            $get_post_meta = get_post_meta($id);
            $metas = get_post($id);
            print_a($metas);
            wp_update_post(array(
        'ID'    =>  $id,
        'post_status'   =>  'publish'
        ));
//            if (!empty($ppp) || $ppp != null) {
//                $post_id = $ppp->ID;
//                echo $post_id . '<br>';
//                $thumbnail_id = get_post_thumbnail_id($id);
//                if (!empty($thumbnail_id)) {
//                    if (set_post_thumbnail($post_id, $thumbnail_id))
//                        echo 'Миниатюра установлена.<br>';
//                    else
//                        echo 'Миниатюра удалена.<br>';
//                }
//                $arg = array(
//                    'ID' => $post_id,
//                    'post_author' => $metas->post_author,
//                );
//                wp_update_post($arg);
//                update_post_meta($post_id, 'email', $get_post_meta['_application'][0]);
//                update_post_meta($post_id, '_job_location', $get_post_meta['_job_location'][0]);
//                update_post_meta($post_id, '_job_expires', $get_post_meta['_job_expires'][0]);
//                update_post_meta($post_id, '_job_salary', $get_post_meta['_job_salary'][0]);
//                update_post_meta($post_id, '_company_name', $get_post_meta['_company_name'][0]);
//                update_post_meta($post_id, '_company_website', $get_post_meta['_company_website'][0]);
//                update_post_meta($post_id, '_company_tagline', $get_post_meta['_company_tagline'][0]);
//                update_post_meta($post_id, '_thumbnail_id', $get_post_meta['_thumbnail_id'][0]);
//                update_post_meta($post_id, 'great_logo_of_the_company', $get_post_meta['great_logo_of_the_company'][0]);
//                echo 'update ' . $title . '<br>';
//            } else {
//                echo 'нет поста ' . $title . '<br>';
//                $post_data = array(
//                    'post_title' => $title,
//                    'post_content' => $metas->post_content,
//                    'post_status' => 'publish',
//                    'post_author' => $metas->post_author,
//                    'post_date' => $metas->post_date, // Время, когда запись была создана.
//                    'post_date_gmt' => $metas->post_date_gmt,
//                    'post_name' => $metas->post_name,
//                    'post_type' => 'job',
//                    'meta_input' => array(
//                        'email' => $get_post_meta['_application'][0],
//                        '_job_location' => $get_post_meta['_job_location'][0],
//                        '_job_expires' => $get_post_meta['_job_expires'][0],
//                        '_job_salary' => $get_post_meta['_job_salary'][0],
//                        '_company_name' => $get_post_meta['_company_name'][0],
//                        '_company_website' => $get_post_meta['_company_website'][0],
//                        '_company_tagline' => $get_post_meta['_company_tagline'][0],
//                        '_thumbnail_id' => $get_post_meta['_thumbnail_id'][0],
//                        'great_logo_of_the_company' => $get_post_meta['great_logo_of_the_company'][0],
//                    ),
//                );
//                $post_ids = wp_insert_post($post_data, true);
//
//                if (is_wp_error($post_ids)) {
//                    echo $post_ids->get_error_message() . '<br>';
//                } else {
//                    echo 'insert ' . $title . '<br>';
//                }
//            }
        endwhile;
        wp_reset_query();
    endif;
} else {
    echo 'hi!!!';
}